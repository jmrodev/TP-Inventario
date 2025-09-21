import glob
import subprocess
import os

def generate_mermaid_images(base_input_directory, output_directory, output_format="png", theme="dark", puppeteer_path=None):
    """
    Finds all .mmd files in the specified input directory and generates an image
    for each using mermaid.cli (mmdc).

    Args:
        base_input_directory (str): The absolute path to the base directory (e.g., project root).
        output_directory (str): The absolute path to the directory where generated images will be saved.
        output_format (str): The output image format (e.g., "png", "svg").
        theme (str): The theme for the generated image (e.g., "dark", "default", "forest").
    """

    # Construct the actual input_directory by joining base_input_directory with "docs"
    input_directory = os.path.join(base_input_directory, "docs")

    # 1. Check if mmdc is installed
    try:
        subprocess.run(["mmdc", "--version"], capture_output=True, check=True)
    except FileNotFoundError:
        print("Error: mermaid.cli (mmdc) is not installed or not in your PATH.")
        print("Please install it globally using: npm install -g @mermaid-js/mermaid-cli")
        return
    except subprocess.CalledProcessError as e:
        print(f"Error checking mmdc version: {e.stderr.decode().strip()}")
        return

    # Ensure output directory exists
    os.makedirs(output_directory, exist_ok=True)

    print(f"DEBUG: Input directory for glob: '{input_directory}'")

    # 2. Find all .mmd files recursively
    mmd_files = glob.glob(os.path.join(input_directory, "**", "*.mmd"), recursive=True)

    if not mmd_files:
        print(f"No .mmd files found in '{input_directory}'.")
        return

    print(f"Found {len(mmd_files)} .mmd file(s) in '{input_directory}'.")

    # --- BEGIN PUPPETEER_EXECUTABLE_PATH CONFIGURATION ---
    # Create a copy of the current environment variables
    env = os.environ.copy()
    # Set the PUPPETEER_EXECUTABLE_PATH environment variable if puppeteer_path is provided
    if puppeteer_path:
        env["PUPPETEER_EXECUTABLE_PATH"] = puppeteer_path
    # --- END PUPPETEER_EXECUTABLE_PATH CONFIGURATION ---

    # 3. Generate image for each .mmd file
    for mmd_file in mmd_files:
        base_name = os.path.splitext(os.path.basename(mmd_file))[0]
        output_image_path = os.path.join(output_directory, f"{base_name}.{output_format}")

        command = [
            "mmdc",
            "-i", mmd_file,
            "-o", output_image_path,
            "-t", theme
        ]

        try:
            print(f"Generating {output_image_path} from {mmd_file}...")
            # Pass the modified environment to subprocess.run
            result = subprocess.run(command, capture_output=True, check=True, env=env)
            if result.stdout:
                print(f"  stdout: {result.stdout.decode().strip()}")
            if result.stderr:
                print(f"  stderr: {result.stderr.decode().strip()}")
            print(f"Successfully generated {output_image_path}")
        except subprocess.CalledProcessError as e:
            print(f"Error generating image for {mmd_file}:")
            print(f"  Command: {' '.join(e.cmd)}")
            print(f"  Return Code: {e.returncode}")
            print(f"  stdout: {e.stdout.decode().strip()}")
            print(f"  stderr: {e.stderr.decode().strip()}")
        except Exception as e:
            print(f"An unexpected error occurred for {mmd_file}: {e}")

    print("Image generation process completed.")

if __name__ == "__main__":
    # Get the directory where the script itself is located
    script_dir = os.path.dirname(os.path.abspath(__file__))

    # Define output directory relative to the script's location
    output_dir = os.path.join(script_dir, "docs", "images")

    print(f"DEBUG: script_dir (base input) before function call: '{script_dir}'")

    puppeteer_executable_path = "/home/jmro/.cache/puppeteer/chrome-headless-shell/linux-140.0.7339.82/chrome-headless-shell-linux64/chrome-headless-shell"

    generate_mermaid_images(base_input_directory=script_dir, output_directory=output_dir, puppeteer_path=puppeteer_executable_path)
