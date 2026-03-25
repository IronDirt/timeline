#!/usr/bin/env python3
"""
optimize_images.py — Livello 3: Esecuzione

Converte immagini PNG e JPG in formato WebP nella directory
public_html/assets/img/. Gli originali rimangono intatti.

Richiede: pip install Pillow
"""

import os
import sys

IMG_DIR = os.path.join(os.path.dirname(__file__), '..', 'public_html', 'assets', 'img')
QUALITY = 80
SUPPORTED_EXTENSIONS = ('.png', '.jpg', '.jpeg')


def main():
    img_dir = os.path.normpath(IMG_DIR)

    if not os.path.isdir(img_dir):
        print(f"ERRORE: Directory immagini non trovata: {img_dir}")
        sys.exit(1)

    try:
        from PIL import Image
    except ImportError:
        print("ERRORE: Pillow non installato. Eseguire: pip install Pillow")
        sys.exit(1)

    count = 0
    for filename in sorted(os.listdir(img_dir)):
        ext = os.path.splitext(filename)[1].lower()
        if ext not in SUPPORTED_EXTENSIONS:
            continue

        filepath = os.path.join(img_dir, filename)
        webp_path = os.path.splitext(filepath)[0] + '.webp'

        if os.path.exists(webp_path):
            print(f"SKIP: {filename} (WebP già esistente)")
            continue

        try:
            img = Image.open(filepath)
            img.save(webp_path, 'WEBP', quality=QUALITY)
            orig_size = os.path.getsize(filepath)
            webp_size = os.path.getsize(webp_path)
            savings = (1 - webp_size / max(1, orig_size)) * 100
            print(f"OK:   {filename} -> {os.path.basename(webp_path)} ({savings:.1f}% riduzione)")
            count += 1
        except Exception as e:
            print(f"ERRORE: {filename} -> {e}")

    print(f"\nConvertite {count} immagini in WebP.")


if __name__ == '__main__':
    main()
