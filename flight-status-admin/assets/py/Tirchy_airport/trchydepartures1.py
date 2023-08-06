import requests
from bs4 import BeautifulSoup
import json
import pandas as pd


trichy_departures = []


def ExtractData(url):
    response = requests.get(url=url).content
    soup = BeautifulSoup(response,"lxml")

    table = soup.find("table",{"class":"tableListingTable"})
    thead = table.find_all("td",{"class":"header"})
    table_head = [td.text.strip() for td in thead]
    

    table_body = table.find_all("tr")

    
    for tr in table_body:
        table_data = [td.text.strip() for td in tr.find_all("td")]
    
    
    
#with open("trichy.csv","w") as csv_file:
    #csv_write = csv.writer(csv_file)
    #csv_write.writerow(trow)
        departures_dict = {}
        departures_dict['data'] =  table_data

        trichy_departures.append(departures_dict)
    print(trichy_departures)


    f = open('assets/py/Tirchy_airport/tdeparture1.json','w')
    f.write(json.dumps(trichy_departures,indent=4))
    f.close()


                
ExtractData(url ="https://www.flightstats.com/go/weblet?guid=49e3481552e7c4c9:6fbd1b7f:126ad2b709d:-3ce3&weblet=status&action=AirportFlightStatus&airportCode=TRZ")  