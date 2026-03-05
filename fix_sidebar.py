import os
import re

admin_dir = r'c:\xampp\htdocs\Activition\admin'
files = [f for f in os.listdir(admin_dir) if f.endswith('.php')]

replacement = "<!-- Admin Sidebar -->\n        <?php require_once __DIR__ . '/../includes/admin_sidebar.php'; ?>"

# Pattern matches from "<!-- Admin Sidebar -->" up to the second closing </div> after the </ul>
pattern = re.compile(r'<!-- Admin Sidebar -->.*?</ul>\s*</div>\s*</div>', re.DOTALL)

for fname in files:
    fpath = os.path.join(admin_dir, fname)
    with open(fpath, 'r', encoding='utf-8') as f:
        content = f.read()
    
    if pattern.search(content):
        new_content = pattern.sub(replacement, content)
        with open(fpath, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f"Updated {fname}")
    else:
        print(f"Skipped {fname} (no match)")
