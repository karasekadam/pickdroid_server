import mysql.connector
import requests
import datetime

# downloads actuall matches
data = requests.get("https://projects.fivethirtyeight.com/soccer-api/club/spi_matches_latest.csv").content
print("downloaded")
data = data.decode("utf-8")
data = data.split("\n")
for row in range(len(data)):
    data[row] = data[row].split(",")

# only matches in future
decimated = []
today = datetime.date.today()
two_weeks = today + datetime.timedelta(days=14)
print(today)
for i in data:
    if len(i) == 23 and i[0] != "season":
        day = i[1].split("-")
        match_day = datetime.date(int(day[0]), int(day[1]), int(day[2]))
        if two_weeks >= match_day >= today:
            for item in range(len(i)):
                if i[item] == "":
                    i[item] = "NULL"
            decimated.append(i)
            # decimated.add((i[1], i[5], i[4])) kdyby se mohlo pořadí týmů měnit


# connects to database
print("connecting to the database")
cnx = mysql.connector.connect(user='kokot', password='kokot123', host='mysql.dangrb.dreamhosters.com', database='pickdroid_db')
# cnx = mysql.connector.connect(user='pallas', password='greplpekl', host='127.0.0.1', database='pickdroid', auth_plugin='mysql_native_password')  # , auth_plugin='mysql_native_password'

print("connected")
cursor = cnx.cursor()

# deletes old matches

print(today)
cursor.execute("DELETE FROM `matches` WHERE date < '" + str(today) + "';")
cnx.commit()

# gets all matches from database
cursor.execute("SELECT * FROM `matches`;")  # WHERE date >= NOW()
matches = cursor.fetchall()


# set of prime keys from existing records
relevant = set()
for k in matches:
    relevant.add((k[2], k[6], k[7]))

# gets all leagues
cursor.execute("SELECT * FROM `leagues`;")
leagues_all = cursor.fetchall()
# set of leagues already in db
leagues = set()
league_names = {}
for i in leagues_all:
    leagues.add(i[3])
    league_names[i[3]] = i[6] if i[6] else i[3]

# gets all clubs
cursor.execute("SELECT * FROM `clubs`;")
clubs = cursor.fetchall()
clubs_set = set()
clubs_name = {}
for club in clubs:
    clubs_name[club[1]] = club[2]
    clubs_set.add(club[1])

print(clubs_name)
print(clubs_name["Sydney FC"])

print(relevant)
# uploads data
for i in decimated:
    if len(i) == 23:
        if i[3] not in leagues:
            print("new league")
            leagues.add(i[3])
            cursor.execute('INSERT INTO leagues(sport, country, name_538, name_fortuna, 538_league_id) VALUES ("Football", "Default", "{}", "-", "{}");'.format(i[3], i[2]))

        if i[4] not in clubs_set:
            print("new team")
            clubs_set.add(i[4])
            cursor.execute('INSERT INTO clubs(538_name, our_name, league) VALUES ("{}", "{}", "{}");'.format(i[4], i[4], i[3]))

        if i[5] not in clubs_set:
            print("new team")
            clubs_set.add(i[5])
            cursor.execute('INSERT INTO clubs(538_name, our_name, league) VALUES ("{}", "{}", "{}");'.format(i[5], i[5], i[3]))

        # makes datetime object
        day = i[1].split("-")
        match_day = datetime.date(int(day[0]), int(day[1]), int(day[2]))

        # finds out if the match exists and then inserts or updates
        team1 = clubs_name[i[4]] if i[4] in clubs_name else i[4]
        team2 = clubs_name[i[5]] if i[5] in clubs_name else i[5]
        league = league_names[i[3]] if i[3] in league_names else i[3]

        match = (match_day.strftime("%Y-%m-%d"), team1, team2)  # nejsem si jistej jestli berem naše týmy, nebo 538
        print("info o zápase: " + team1 + ", " + team2 + ", " + league)
        print(match)
        if match in relevant:
            print("updatuju")
            cursor.execute('UPDATE matches SET prob1={}, prob2={}, probtie={}'.format(i[8], i[9], i[10]) + ' WHERE date="{}" AND team1 = "{}" AND team2 = "{}";'.format(i[1], team1, team2))
        else:
            print("neupdatuju")
            cursor.execute('INSERT INTO matches(season, date, league_id, league, team1, team2, prob1, prob2, probtie, priority) VALUES ({}, "{}", {}, "{}", "{}", "{}", {}, {}, {}, {})'.format(i[0], i[1], i[2], i[3], team1, team2, i[8], i[9], i[10], 10))

cnx.commit()

cnx.close()
# hatayspor
