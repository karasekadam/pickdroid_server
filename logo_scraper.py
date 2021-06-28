import requests
import bs4
import html5lib
import os.path


league_names = {
    "champions-league": "UEFA Champions League",
    "europa-league": "UEFA Europa League",
    "bundesliga-austria": "Austrian T-Mobile Bundesliga",
    "first-division-a": "Belgian Jupiler League",
    "superligaen": "Danish SAS-Ligaen",
    "premier-league": "Barclays Premier League",
    "championship": "English League Championship",
    "league-one": "English League One",
    "league-two": "English League Two",
    "fa-wsl": "FA Women's Super League",
    "ligue-1": "French Ligue 1",
    "ligue-2": "French Ligue 2",
    "bundesliga": "German Bundesliga",
    "bundesliga-2": "German 2. Bundesliga",
    "super-league-greece": "",
    "serie-a": "Italy Serie A",
    "serie-b": "Italy Serie B",
    "eredivisie": "Dutch Eredivisie",
    "eliteserien": "Norwegian Tippeligaen",
    "primeira-liga": "Portuguese Liga",
    "premier-league-russia": "Russian Premier Liga",
    "premiership": "Scottish Premiership",
    "la-liga": "Spanish Primera Division",
    "la-liga-2": "Spanish Segunda Division",
    "allsvenskan": "Swedish Allsvenskan",
    "super-league": "Swiss Raiffeisen Super League",
    "super-lig": "Turkish Turkcell Super Lig",
    "liga-mx": "Mexican Primera Division Torneo Clausura",
    "mls": "Major League Soccer",
    "mls-is-back": "Major League Soccer",
    "usl": "United Soccer League",
    "nwsl": "National Women's Soccer League",
    "nwsl-challenge-cup": "National Women's Soccer League",
    "superliga": "",
    "brasileirao": "Brasileiro Série A",
    "a-league": "Australian A-League",
    "chinese-super-league": "",
    "j1-league": "Japanese J League",
    "premier-division": "",
}

print("getting webpage")
main_page = requests.get("https://projects.fivethirtyeight.com/soccer-predictions/")
print("webpage got")

# processing the main page
soup = bs4.BeautifulSoup(main_page.content, "html5lib")
league_div = soup.find("select", {"id": "leagueselector"})
leagues_tag = league_div.findAll("option", {"class": "nav-option"})

for k in leagues_tag:
    liga = k["value"]

    # league is not in dict
    if liga not in league_names:
        print('"' + liga + '": "",')

    # league without 538 api name
    if not league_names[liga]:
        print("not translatable: ", liga)
        continue

    if not os.path.isfile("/home/elivano/loga/" + league_names[liga] + ".png"):  # "/home/elivano/loga/"
        print("new league logo :" + league_names[liga])
        league_logo = clubs_tags_page.find("img", {"class": "logo-img"})
        # league logo scrape
        suburl = league_logo["src"]
        league_logo_url = requests.get("https://projects.fivethirtyeight.com" + suburl)
        file = open("/home/elivano/loga/" + league_names[liga] + ".png", "wb")
        file.write(league_logo_url.content)
        file.close()

    # one league
    league_page = requests.get("https://projects.fivethirtyeight.com/soccer-predictions/" + liga + "/").content
    clubs_tags_page = bs4.BeautifulSoup(league_page, "html5lib")
    clubs_tags = clubs_tags_page.find("div", {"id": "forecast-table-wrapper"}).find("tbody")
    for i in clubs_tags:
        name = i["data-str"]
        title = name
        if "\\" in name:
            title = name.replace("\\", "-")
        if "/" in name:
            title = name.replace("/", "-")

        if not os.path.isfile("/home/elivano/loga/" + title + ".png"):  # "/home/elivano/loga/"
            print("new club logo: " + title)
            logo_url = i.find("img")["src"]
            logo = requests.get(logo_url)
            if logo.ok:
                file = open("/home/elivano/loga/" + title + ".png", "wb")
                file.write(logo.content)
                file.close()
            else:
                print("Logo not downloaded: " + name)
