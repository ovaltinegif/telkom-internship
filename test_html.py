import sys
from bs4 import BeautifulSoup

with open('rendered.html', 'r', encoding='utf-8') as f:
    html = f.read()

soup = BeautifulSoup(html, 'html.parser')
main = soup.find('main')
if main:
    print(f"Main tag found! Parent is {main.parent.name}")
    footer = main.find('footer')
    if footer:
        print("Footer found INSIDE main!")
    else:
        print("Footer is NOT inside main!")
        
    top_bar = soup.find('header', class_='h-20')
    if top_bar:
        print(f"Top bar found! Parent is {top_bar.parent.name}")
        
else:
    print("Main tag NOT found!")
