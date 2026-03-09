import re

file_content = open("resources/views/admin/users/index.blade.php", "r").read()

lines = file_content.split("\n")

if_stack = []

for i, line in enumerate(lines):
    if "@if" in line and "@endif" not in line:
        # Ignore comments or other directives like @endif
        if re.search(r'@if\s*\(', line):
            if_stack.append(i + 1)
    if "@endif" in line:
        if len(if_stack) > 0:
            match = if_stack.pop()
            print(f"Matched @endif on line {i + 1} with @if on line {match}")
        else:
            print(f"UNMATCHED @endif on line {i + 1}")

if len(if_stack) > 0:
    for line_num in if_stack:
        print(f"UNMATCHED @if on line {line_num}")
