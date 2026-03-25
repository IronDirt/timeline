#!/usr/bin/env python3
"""
minify_assets.py — Livello 3: Esecuzione

Minifica i file CSS e JS dalla directory public_html/assets/
generando versioni .min.css e .min.js.

Richiede: pip install cssmin jsmin
"""

import os
import sys

ASSETS_DIR = os.path.join(os.path.dirname(__file__), '..', 'public_html', 'assets')


def minify_css(content):
    """Minificazione CSS base: rimuove commenti, spazi bianchi e newline."""
    import re
    # Rimuovi commenti
    content = re.sub(r'/\*.*?\*/', '', content, flags=re.DOTALL)
    # Rimuovi spazi bianchi superflui
    content = re.sub(r'\s+', ' ', content)
    content = re.sub(r'\s*([{}:;,])\s*', r'\1', content)
    content = content.strip()
    return content


def minify_js(content):
    """Minificazione JS base: rimuove commenti a riga singola e spazi bianchi."""
    import re
    # Rimuovi commenti // ma non dentro stringhe
    lines = content.split('\n')
    result = []
    for line in lines:
        stripped = line.strip()
        if stripped.startswith('//'):
            continue
        result.append(stripped)
    return ' '.join(result)


def main():
    assets_dir = os.path.normpath(ASSETS_DIR)

    if not os.path.isdir(assets_dir):
        print(f"ERRORE: Directory assets non trovata: {assets_dir}")
        sys.exit(1)

    count = 0
    for root, dirs, files in os.walk(assets_dir):
        for filename in files:
            filepath = os.path.join(root, filename)

            if filename.endswith('.css') and not filename.endswith('.min.css'):
                with open(filepath, 'r', encoding='utf-8') as f:
                    content = f.read()
                minified = minify_css(content)
                out_path = filepath.replace('.css', '.min.css')
                with open(out_path, 'w', encoding='utf-8') as f:
                    f.write(minified)
                savings = (1 - len(minified) / max(1, len(content))) * 100
                print(f"CSS: {filename} -> {os.path.basename(out_path)} ({savings:.1f}% riduzione)")
                count += 1

            elif filename.endswith('.js') and not filename.endswith('.min.js'):
                with open(filepath, 'r', encoding='utf-8') as f:
                    content = f.read()
                minified = minify_js(content)
                out_path = filepath.replace('.js', '.min.js')
                with open(out_path, 'w', encoding='utf-8') as f:
                    f.write(minified)
                savings = (1 - len(minified) / max(1, len(content))) * 100
                print(f"JS:  {filename} -> {os.path.basename(out_path)} ({savings:.1f}% riduzione)")
                count += 1

    print(f"\nMinificati {count} file.")


if __name__ == '__main__':
    main()
