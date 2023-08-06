import requests
from bs4 import BeautifulSoup
import json
import csv
import pandas as pd

trichy_arrivals = []


def ExtractData(url):
    response = requests.get(url=url).content
    soup = BeautifulSoup(response,"lxml")

    table = soup.find("table",{"class":"tableListingTable"})
    thead = table.find_all("td",{"class":"header"})
    table_head = [td.text.strip() for td in thead]
    

    table_body = table.find_all("tr")

    
    for tr in table_body:
        table_data = [td.text.strip() for td in tr.find_all("td")]


        arrivals_dict = {}
        arrivals_dict['data'] =  table_data

        trichy_arrivals.append(arrivals_dict)
    print(trichy_arrivals)


    f = open('assets/py/Tirchy_airport/tarrival1.json','w')
    f.write(json.dumps(trichy_arrivals,indent=2))
    f.close()

                
ExtractData(url ="https://www.flightstats.com/go/weblet?guid=49e3481552e7c4c9:6fbd1b7f:126ad2b709d:-3ce3&imageColor=Grey&language=English&weblet=status&action=AirportFlightStatus&airportCode=TRZ&airportQueryType=1" )