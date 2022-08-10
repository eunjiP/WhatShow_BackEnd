from urllib import response
import requests

movieCode = ''
url = 'https://movie.naver.com/movie/bi/mi/basic.naver?code=${movieCode}'
param = {
    'movieCode' : '81888',
}

response = requests.get(url, params=param)
html = response.json()
result = open('summary.txt', 'w')
for i in html:
    print(url)
print(response.status_code)
print(response.url)