import subprocess
subprocess.run(['cwebp', '-q', '80', 'public/images/alternative/default_picture.jpeg', '-o', 'public/images/webp/default_picture.webp'])
