#!/usr/bin/env python3
"""
check_translations.py — Livello 3: Esecuzione

Verifica che ogni chiave presente nel file di lingua di riferimento (it.php)
esista anche in tutti gli altri file di lingua PHP.
Segnala le chiavi mancanti per ciascun file.
"""

import os
import re
import sys

LANG_DIR = os.path.join(os.path.dirname(__file__), '..', 'public_html', 'lang')
REFERENCE_LANG = 'it'
LANG_EXTENSIONS = '.php'


def extract_keys(filepath):
    """Estrae le chiavi da un file PHP che restituisce un array associativo."""
    keys = []
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Cerca pattern: 'chiave' =>
    for match in re.finditer(r"'(\w+)'\s*=>", content):
        keys.append(match.group(1))

    return set(keys)


def main():
    lang_dir = os.path.normpath(LANG_DIR)

    if not os.path.isdir(lang_dir):
        print(f"ERRORE: Directory lingua non trovata: {lang_dir}")
        sys.exit(1)

    # File di riferimento
    ref_file = os.path.join(lang_dir, f'{REFERENCE_LANG}{LANG_EXTENSIONS}')
    if not os.path.isfile(ref_file):
        print(f"ERRORE: File di riferimento non trovato: {ref_file}")
        sys.exit(1)

    ref_keys = extract_keys(ref_file)
    print(f"Lingua di riferimento: {REFERENCE_LANG} ({len(ref_keys)} chiavi)")
    print("-" * 50)

    has_errors = False

    # Controlla tutti gli altri file di lingua
    for filename in sorted(os.listdir(lang_dir)):
        if not filename.endswith(LANG_EXTENSIONS):
            continue
        lang_code = filename.replace(LANG_EXTENSIONS, '')
        if lang_code == REFERENCE_LANG:
            continue

        filepath = os.path.join(lang_dir, filename)
        lang_keys = extract_keys(filepath)

        missing = ref_keys - lang_keys
        extra = lang_keys - ref_keys

        if missing:
            has_errors = True
            print(f"\n❌ {lang_code}: {len(missing)} chiavi MANCANTI:")
            for key in sorted(missing):
                print(f"   - {key}")

        if extra:
            print(f"\n⚠️  {lang_code}: {len(extra)} chiavi EXTRA (non in {REFERENCE_LANG}):")
            for key in sorted(extra):
                print(f"   + {key}")

        if not missing and not extra:
            print(f"✅ {lang_code}: OK ({len(lang_keys)} chiavi)")

    print("\n" + "=" * 50)
    if has_errors:
        print("RISULTATO: Chiavi mancanti trovate! Correggere prima del deploy.")
        sys.exit(1)
    else:
        print("RISULTATO: Tutte le traduzioni sono complete.")
        sys.exit(0)


if __name__ == '__main__':
    main()
