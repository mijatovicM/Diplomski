import os
import re

file_name = 'footer.php'
base_name = '.'.join(file_name.split('.')[:-1])
css_file = os.path.join('src/css/', f"{base_name}.css")

if __name__ == '__main__':
    class_name = base_name
    with open(os.path.join('diplomski', file_name), encoding='utf8') as file:
        content = file.read()
        regex = 'style=[\s\S]+?[\'"]'

        to_replace = re.findall(regex, content)
        for i, style in enumerate(to_replace):
            content = content.replace(style, f'class="{class_name}{i}"')

        to_write = [x.split('style=')[-1] for x in to_replace]
        to_write = [x.replace('\'', '') for x in to_write]
        to_write = [x.replace('"', '') for x in to_write]
        to_write = [f'.{class_name}{i}' + '{' + f'{x}' + '}' for i, x in enumerate(to_write)]
        with open(os.path.join('diplomski', css_file), 'w') as css:
            css.write('\n'.join(to_write))
        print('asdf')

    with open(os.path.join('diplomski', file_name), 'w', encoding='utf8') as file:
        file.write(content)

