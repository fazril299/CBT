import sys
from PIL import Image

def remove_background(input_path, output_path):
    img = Image.open(input_path).convert("RGBA")
    
    # We will do a BFS/FloodFill from (0,0) to find all background pixels
    width, height = img.size
    pixels = img.load()
    
    # The background color at 0,0
    bg_color = pixels[0, 0]
    
    # Threshold for color difference
    def is_similar(c1, c2, threshold=30):
        return abs(c1[0]-c2[0]) < threshold and abs(c1[1]-c2[1]) < threshold and abs(c1[2]-c2[2]) < threshold

    # Queue for BFS
    q = [(0,0)]
    visited = set()
    visited.add((0,0))
    
    while q:
        x, y = q.pop(0)
        
        # Make pixel transparent
        pixels[x, y] = (0, 0, 0, 0)
        
        # Check neighbors
        for dx, dy in [(0,1), (1,0), (0,-1), (-1,0)]:
            nx, ny = x + dx, y + dy
            if 0 <= nx < width and 0 <= ny < height and (nx, ny) not in visited:
                if is_similar(pixels[nx, ny], bg_color):
                    visited.add((nx, ny))
                    q.append((nx, ny))

    img.save(output_path, "PNG")
    print(f"Saved transparent image to {output_path}")

input_img = r"C:/Users/Thinkpad T14/.gemini/antigravity/brain/9d9f8814-5f93-4f6a-bd8f-3d85da98b207/.user_uploaded/media_1790646652574.png"
output_img = r"C:/laragon/www/CBT_produktif/public/images/admin_hero.png"

remove_background(input_img, output_img)
