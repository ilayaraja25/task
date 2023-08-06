import requests
from bs4 import BeautifulSoup
import json
import pandas as pd

def ExtractData(url):
  response = requests.get(url=url).content
  soup = BeautifulSoup(response,"lxml")
  
  table1 = soup.find("div", {"class":"flights-info"})
  title1 = table1.find_all("div", {"class":"flight-row flight-titol"})
  table_head = [div.text.strip() for div in title1]

  table_body = table1.find_all("div",{"class":"flight-col flight-col__dest-term"})
  origin1 = [div.text.strip() for div in table_body]
  
  table_column = table1.find_all("div",{"class":"flight-col__subbox-term"})
  table_header = table1.find_all("div",{"class":"flight-col flight-col__hour"})
  arrival1 = [div.text.strip() for div in table_header]

    
  table_row1 = table1.find_all("div",{"class":"flight-col flight-col__flight"})
  flight1 = [div.text.strip() for div in table_row1]
    
  table_row2 = table1.find_all("div",{"class":"flight-col flight-col__airline"})
  airline1 = [div.text.strip() for div in table_row2]
    
    
  table_column1 = table1.find_all("div",{"class":"flight-col flight-col__terminal"})
  terminal1 = [div.text.strip() for div in table_column1]

  
  statustry = soup.select('.flight-col__status')
  status1 = [div.text.strip() for div in statustry]
  

  links = [a['href'] for a in soup.find_all('a',href = True)]

  def filter_links(links):
    filtered_links = []
    for link in links:
        if link.startswith('?tp=6'):
          filtered_links.append(link)
    return filtered_links
  

  for link in filter_links(links):
    next_url = "https://www.chennaiairport.com/maa-arrivals" + link
    page_content = requests.get(next_url)
    soup1 = BeautifulSoup(page_content.text, 'lxml')
    

    table2 = soup1.find("div", {"class":"flights-info"})
    title2 = table2.find_all("div", {"class":"flight-row flight-titol"})
    table_title1 = [div.text.strip() for div in title2]
    
    tab_body = table2.find_all("div",{"class":"flight-col flight-col__dest-term"})
    origin2 = [div.text.strip() for div in tab_body]
    
    tab_column = table2.find_all("div",{"class":"flight-col__subbox-term"})
    tab_header = table2.find_all("div",{"class":"flight-col flight-col__hour"})
    arrival2 = [div.text.strip() for div in tab_header]
    
    tab_row1 = table2.find_all("div",{"class":"flight-col flight-col__flight"})
    flight2 = [div.text.strip() for div in tab_row1]
    
    tab_row2 = table2.find_all("div",{"class":"flight-col flight-col__airline"})
    airline2 = [div.text.strip() for div in tab_row2]
    
    
    tab_column1 = table2.find_all("div",{"class":"flight-col flight-col__terminal"})
    terminal2 = [div.text.strip() for div in tab_column1]

    
    statustry1 = soup1.select('.flight-col__status')
    status2 = [div.text.strip() for div in statustry1]
    

    links2 = [a['href'] for a in soup.find_all('a',href = True)]

    def filter_links2(links2):
      filtered_links2 = []
      for link in links2:
          if link.startswith('?tp=12'):
            filtered_links2.append(link)
      return filtered_links2
#print(filter_links1(links1))



    for link in filter_links2(links2):
      next_url2 = "https://www.chennaiairport.com/maa-arrivals" + link
      page_content2 = requests.get(next_url2)
      soup3 = BeautifulSoup(page_content2.text, 'lxml')
      

      table4 = soup3.find("div", {"class":"flights-info"})
      title4 = table4.find_all("div", {"class":"flight-row flight-titol"})
      table_title4 = [div.text.strip() for div in title4]
    

      t_bod = table4.find_all("div",{"class":"flight-col flight-col__dest-term"})
      origin4 = [div.text.strip() for div in t_bod]
      
    
      t_colum = table4.find_all("div",{"class":"flight-col__subbox-term"})
      t_heade = table4.find_all("div",{"class":"flight-col flight-col__hour"})
      arrival4 = [div.text.strip() for div in t_heade]

    
      t_ro1 = table4.find_all("div",{"class":"flight-col flight-col__flight"})
      flight4 = [div.text.strip() for div in t_ro1]
    
      t_ro2 = table4.find_all("div",{"class":"flight-col flight-col__airline"})
      airline4 = [div.text.strip() for div in t_ro2]
      
      t_colum1 = table4.find_all("div",{"class":"flight-col flight-col__terminal"})
      terminal4 = [div.text.strip() for div in t_colum1]
      

      
      statustry3 = soup3.select('.flight-col__status')
      status4 = [div.text.strip() for div in statustry3]
      

      links3 = [a['href'] for a in soup.find_all('a',href = True)]

      def filter_links3(links3):
        filtered_links3 = []
        for link in links3:
          if link.startswith('?tp=18'):
            filtered_links3.append(link)
        return filtered_links3
#print(filter_links1(links1))
    
      for link in filter_links3(links3):
        next_url3 = "https://www.chennaiairport.com/maa-arrivals" + link
        page_content3 = requests.get(next_url3)
        soup4 = BeautifulSoup(page_content3.text, 'lxml')
        

        table3 = soup4.find("div", {"class":"flights-info"})
        title3 = table3.find_all("div", {"class":"flight-row flight-titol"})
        table_title3 = [div.text.strip() for div in title2]
    

        tab_body = table3.find_all("div",{"class":"flight-col flight-col__dest-term"})
        origin3 = [div.text.strip() for div in tab_body]
        
    
        tab_colum = table3.find_all("div",{"class":"flight-col__subbox-term"})
        tab_heade = table3.find_all("div",{"class":"flight-col flight-col__hour"})
        arrival3 = [div.text.strip() for div in tab_heade]
        
    
        tab_rw1 = table3.find_all("div",{"class":"flight-col flight-col__flight"})
        flight3 = [div.text.strip() for div in tab_rw1]
        
    
        tab_rw2 = table3.find_all("div",{"class":"flight-col flight-col__airline"})
        airline3 = [div.text.strip() for div in tab_rw2]

        tab_colum1 = table3.find_all("div",{"class":"flight-col flight-col__terminal"})
        terminal3 = [div.text.strip() for div in tab_colum1]
        

        
        statustry4 = soup4.select('.flight-col__status')
        status3 = [div.text.strip() for div in statustry4]

        arrivals = {}
        arrivals['origin'] = origin1,origin2,origin4,origin3
        arrivals['arrival'] = arrival1,arrival2,arrival4,arrival3
        arrivals['flight'] = flight1,flight2,flight4,flight3
        arrivals['airline'] = airline1,airline2,airline4,airline3
        arrivals['terminal'] = terminal1,terminal2,terminal4,terminal3
        arrivals['status'] = status1,status2,status4,status3
        

         
        with open('assets/py/Chennai_airport/arrivals2.json','w') as f:
          f.write(json.dumps(arrivals,indent=2))
          f.close()       
        
    
ExtractData(url = "https://www.chennaiairport.com/maa-arrivals?tp=0")
   
    #with open('arrivals.json','w') as f:
      #f.write(json.dumps(arrivals,indent=2))
      #f.close()
    