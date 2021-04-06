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
# cnx = mysql.connector.connect(user='kokot', password='kokot123', host='mysql.dangrb.dreamhosters.com', database='pickdroid_db')
cnx = mysql.connector.connect(user='pallas', password='greplpekl', host='127.0.0.1', database='pickdroid', auth_plugin='mysql_native_password')  # , auth_plugin='mysql_native_password'

print("connected")
cursor = cnx.cursor()

# deletes old matches
cursor.execute("DELETE FROM `matches` WHERE date < NOW();")

# gets all matches from database
cursor.execute("SELECT * FROM `matches`")  # WHERE date >= NOW()
result = cursor.fetchall()

cursor.execute("SELECT * FROM `leagues`")
leagues_all = cursor.fetchall()

# set of prime keys from existing records
relevant = set()
for k in result:
    relevant.add((k[1], k[4], k[5]))

leagues = set()
for i in leagues_all:
    leagues.add(i[3])


for i in decimated:
    if len(i) == 23:
        if i[3] not in leagues:
            leagues.add(i[3])
            cursor.execute('INSERT INTO leagues(sport, country, name_538, name_fortuna, 538_league_id) VALUES ("Football", "Default", "{}", "-", "{}");'.format(i[3], i[2]))

        # makes datetime object
        day = i[1].split("-")
        match_day = datetime.date(int(day[0]), int(day[1]), int(day[2]))
        match = (match_day, i[4], i[5])
        # finds out if the match exists and then inserts or updates
        if match in relevant:
            cursor.execute('UPDATE matches SET season={}, date="{}", league_id={}, league="{}", team1="{}", team2="{}", prob1={}, prob2={}, probtie={}, priority={}'.format(i[0], i[1], i[2], i[3], i[4], i[5], i[8], i[9], i[10], 10) + ' WHERE date="{}" AND team1 = "{}" AND team2 = "{}";'.format(i[1], i[4], i[5]))
        else:
            cursor.execute('INSERT INTO matches(season, date, league_id, league, team1, team2, prob1, prob2, probtie, priority) VALUES ({}, "{}", {}, "{}", "{}", "{}", {}, {}, {}, {})'.format(i[0], i[1], i[2], i[3], i[4], i[5], i[8], i[9], i[10], 10))

cnx.commit()
cnx.close()
