
import os
import glob

directory = "/home/dzakihamid/Desktop/telkom-internship/public/images"
exclude_files = ["char-female.png", "char-male.png", "logo-telkom.png"]

# Get all files in directory
files = [f for f in os.listdir(directory) if os.path.isfile(os.path.join(directory, f))]

# Filter files to rename (images that are not in exclude list)
files_to_rename = [f for f in files if f not in exclude_files]
files_to_rename.sort() # Sort to ensure deterministic order

counter = 1
for filename in files_to_rename:
    extension = os.path.splitext(filename)[1]
    if not extension:
        extension = ".jpg" # Default to jpg if no extension, though unlikely based on `ls` output
    
    new_name = f"gallery-{counter:02d}{extension}"
    
    # Handle overlap if file already exists (unlikely in this fresh sequence but good practice)
    while os.path.exists(os.path.join(directory, new_name)):
         counter += 1
         new_name = f"gallery-{counter:02d}{extension}"

    old_path = os.path.join(directory, filename)
    new_path = os.path.join(directory, new_name)
    
    print(f"Renaming '{filename}' to '{new_name}'")
    os.rename(old_path, new_path)
    counter += 1

print("Renaming complete.")
