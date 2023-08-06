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
  destination1 = [div.text.strip() for div in table_body]
  
  table_column = table1.find_all("div",{"class":"flight-col__subbox-term"})
  table_header = table1.find_all("div",{"class":"flight-col flight-col__hour"})
  departure1 = [div.text.strip() for div in table_header]

    
  table_row1 = table1.find_all("div",{"class":"flight-col flight-col__flight"})
  flight1 = [div.text.strip() for div in table_row1]
    
  table_row2 = table1.find_all("div",{"class":"flight-col flight-col__airline"})
  airline1 = [div.text.strip() for div in table_row2]
    
    
  table_column1 = table1.find_all("div",{"class":"flight-col flight-col__terminal"})
  terminal1 = [div.text.strip() for div in table_column1]

  statustry = soup.select('.flight-col__status')
  status1 = [div.text.strip() for div in statustry]
  

  #table_column3 = table1.find_all("div",{"class":"flight-col flight-col__status"})
  #table_data6 = [div.text.strip() for div in table_column3]
  #table_column2 = table1.find_all("div",{"class":"flight-col flight-col__status flight-col__status--G"})
  #table_data5 = [div.text.strip() for div in table_column2]
  #table_column4 = table1.find_all("div",{"class":"flight-col flight-col__status flight-col__status--GR"})
  #table_data8 = [div.text.strip() for div in table_column4]
  #table_column5 = table1.find_all("div",{"class":"flight-col flight-col__status flight-col__status--Y"})
  #table_data9 = [div.text.strip() for div in table_column5]
  #table_column6 = table1.find_all("div",{"class":"flight-col flight-col__status flight-col__status--R"})
  #table_data10 = [div.text.strip() for div in table_column6]
  #table_column7 = table1.find_all("div",{"class":"flight-col flight-col__status flight-col__status--O"})
  #table_data11 = [div.text.strip() for div in table_column7]
  
  #status1 = table_data6+table_data5+table_data8+table_data9+table_data10+table_data11
  

  links = [a['href'] for a in soup.find_all('a',href = True)]

  def filter_links(links):
    filtered_links = []
    for link in links:
        if link.startswith('?tp=6'):
          filtered_links.append(link)
    return filtered_links
  

  for link in filter_links(links):
    next_url = "https://www.chennaiairport.com/maa-departures" + link
    page_content = requests.get(next_url)
    soup1 = BeautifulSoup(page_content.text, 'lxml')
    

    table2 = soup1.find("div", {"class":"flights-info"})
    title2 = table2.find_all("div", {"class":"flight-row flight-titol"})
    table_body1 = [div.text.strip() for div in title2]
    tab_body = table2.find_all("div",{"class":"flight-col flight-col__dest-term"})
    destination2 = [div.text.strip() for div in tab_body]
    
    tab_column = table2.find_all("div",{"class":"flight-col__subbox-term"})
    tab_header = table2.find_all("div",{"class":"flight-col flight-col__hour"})
    departure2 = [div.text.strip() for div in tab_header]
    
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
      next_url2 = "https://www.chennaiairport.com/maa-departures" + link
      page_content2 = requests.get(next_url2)
      soup3 = BeautifulSoup(page_content2.text, 'lxml')
      

      table4 = soup3.find("div", {"class":"flights-info"})
      title4 = table4.find_all("div", {"class":"flight-row flight-titol"})
      table_title4 = [div.text.strip() for div in title4]
    

      t_bod = table4.find_all("div",{"class":"flight-col flight-col__dest-term"})
      destination4 = [div.text.strip() for div in t_bod]
      
    
      t_colum = table4.find_all("div",{"class":"flight-col__subbox-term"})
      t_heade = table4.find_all("div",{"class":"flight-col flight-col__hour"})
      departure4 = [div.text.strip() for div in t_heade]

    
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
        next_url3 = "https://www.chennaiairport.com/maa-departures" + link
        page_content3 = requests.get(next_url3)
        soup4 = BeautifulSoup(page_content3.text, 'lxml')
        

        table3 = soup4.find("div", {"class":"flights-info"})
        title3 = table3.find_all("div", {"class":"flight-row flight-titol"})
        table_title3 = [div.text.strip() for div in title2]
    

        tab_body = table3.find_all("div",{"class":"flight-col flight-col__dest-term"})
        destination3 = [div.text.strip() for div in tab_body]
        
    
        tab_colum = table3.find_all("div",{"class":"flight-col__subbox-term"})
        tab_heade = table3.find_all("div",{"class":"flight-col flight-col__hour"})
        departure3 = [div.text.strip() for div in tab_heade]
        
    
        tab_rw1 = table3.find_all("div",{"class":"flight-col flight-col__flight"})
        flight3 = [div.text.strip() for div in tab_rw1]
        
    
        tab_rw2 = table3.find_all("div",{"class":"flight-col flight-col__airline"})
        airline3 = [div.text.strip() for div in tab_rw2]

        tab_colum1 = table3.find_all("div",{"class":"flight-col flight-col__terminal"})
        terminal3 = [div.text.strip() for div in tab_colum1]
        

        
        statustry4 = soup4.select('.flight-col__status')
        status3 = [div.text.strip() for div in statustry4]
      
        

        departures = {}
        departures['origin'] = destination1,destination2,destination4,destination3
        departures['arrival'] = departure1,departure2,departure4,departure3
        departures['flight'] = flight1,flight2,flight4,flight3
        departures['airline'] = airline1,airline2,airline4,airline3
        departures['terminal'] = terminal1,terminal2,terminal4,terminal3
        departures['status'] = status1,status2,status4,status3
        

         
        with open('assets/py/Chennai_airport/departures2.json','w') as f:
          f.write(json.dumps(departures,indent=2))
          f.close()       
        
    
ExtractData(url = "https://www.chennaiairport.com/maa-departures?tp=0")