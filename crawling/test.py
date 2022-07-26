import requests
from bs4 import BeautifulSoup


url = 'http://www.cgv.co.kr/common/showtimes/iframeTheater.aspx?areacode=11&theatercode=0147&date=20220725'
response = requests.get(url)
html = response.text
soup = BeautifulSoup(html, 'html.parser')
movies = soup.select('.sect-showtimes .info-movie strong')
# print(movies)
# movie_titles = movie_total.find_all('div', class_='list_tit')


f = open('./movie.txt', 'w', encoding='utf-8')
for movie in movies:
    title = movie.select_one('div > div.info-movie > a > strong').get_text().split()
    f.write(title)
    f.write('\n')

# print(movie_titles)


# f = open('./movie.txt', 'w', encoding='utf-8')
# for movie in movie_titles:
#     movie = BeautifulSoup(movie)
#     movie_title = BeautifulSoup(movie.find_all('div', class_='list_tit')).find('p')
#     movie_time = BeautifulSoup(movie.find_all('ul', class_='list_time')).find('dd', class_='time').find('strong')

#     f.write(movie_title)
#     f.write(',')
#     f.write(movie_time)
#     f.write('\n')
# f.close() 