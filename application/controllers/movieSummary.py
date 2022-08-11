import requests
from bs4 import BeautifulSoup

url = 'https://movie.naver.com/movie/bi/mi/basic.naver?code='
f = open('C:\Apache24\WhatShow_BackEnd\movie_code.txt', 'r')
code = f.readline()
f.close()
print(code)
url += code
response = requests.get(url)
html = response.text
soup = BeautifulSoup(html, 'html.parser')
story_title = soup.select('#content > div > div > div > div > div > h5')
story = soup.select('#content > div.article > div.section_group.section_group_frst > div:nth-child(1) > div > div.story_area > p')
img = soup.select('#content > div.article > div.mv_info_area > div.poster > a > img')

f = open('./movie_story.txt', 'w', encoding='utf-8')
for title in story_title:
    f.write(title.text)
    f.write('\n')
for movie_s in story:
    f.write(movie_s.text)
    f.write('\n')
f.close()

f = open('./movie_img.txt', 'w', encoding='utf-8')
for movie_img in img:
    f.write(movie_img['src'])
    f.write('\n')
f.close()
