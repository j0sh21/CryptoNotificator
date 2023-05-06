import mariadb
import config

user = config.duser
password = config.dpassword
host = config.dhost
database = config.ddatabase

def updateconf(usid_u, curid_u):
    con = mariadb.connect(user=user, password=password, host=host, database=database)
    cur = con.cursor()
    e = f"UPDATE confpy SET new = 0 where new = 1 and usid={usid_u} and curid={curid_u}"
    cur.execute(e)
    con.commit()

def getAlertsUsid():
    con = mariadb.connect(user=user, password=password, host=host, database=database)
    cur = con.cursor()
    e = f"Select distinct usid from confpy"
    cur.execute(e)
    usid = cur.fetchall()
    return usid

def getusname(usid_g):
    con = mariadb.connect(user=user, password=password, host=host, database=database)
    cur = con.cursor()
    e = f"Select user from users where id = {usid_g}"
    cur.execute(e)
    for name in cur.fetchone():
        return name

def getmail(usid_g):
    con = mariadb.connect(user=user, password=password, host=host, database=database)
    cur = con.cursor()
    e = f"Select email from users where id = {usid_g}"
    cur.execute(e)
    for mail in cur.fetchone():
        return mail

def setconf(new_s,upper_s,lower_s):
    delete('confpy')
    con = mariadb.connect(user=user, password=password, host=host, database=database)
    cur = con.cursor()
    e = f"Insert Into confpy (new, upper, lower) Values ({new_s},{upper_s},{lower_s})"
    cur.execute(e)
    con.commit()

def getconf(field_g, usid_g, curid_g):
    con = mariadb.connect(user=user, password=password, host=host, database=database)
    cur = con.cursor()
    e = f"Select {field_g} from confpy where usid={usid_g} and curid={curid_g}"
    cur.execute(e)
    if field_g == 'new':
        for new in cur.fetchone():
            return new
    if field_g == 'upper':
        for upper in cur.fetchone():
            return upper
    if field_g == 'lower':
        for lower in cur.fetchone():
            return lower
    con.commit()

def delete(table_d):
    con = mariadb.connect(user=user, password=password, host=host, database=database)
    cur = con.cursor()
    e = f"DELETE from {table_d}"
    cur.execute(e)
    con.commit()

def html(id_h, symbol_h):
    con = mariadb.connect(user=user, password=password, host=host, database=database)
    cur = con.cursor()
    e = "Insert into coins (id, coin) VALUES (" + id_h + ",'" + str(symbol_h) + "')"
    cur.execute(e)
    con.commit()

def create(symbol_i):
    con = mariadb.connect(user=user, password=password, host=host, database=database)
    cur = con.cursor()
    e = 'Create Table ' + symbol_i + ' (price float, datum datetime, volume_24h float, volume_change_24h float, percent_change_1h float, percent_change_24h float, percent_change_7d float, percent_change_30d float, percent_change_60d float, percent_change_90d float, market_cap float, market_cap_dominance float, cmc_rank int)'
    cur.execute(e)
    e = "create or replace view MAX_H_" + str(symbol_i) + " as select DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%d.%m.%Y:%H') as Tag_Stunde,  DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%H:%i') as Uhrzeit, max(price) as maxp from "+ str(symbol_i)+" where (price, DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%d.%m.%Y:%H')) in (Select max(price), DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%d.%m.%Y:%H') from "+ str(symbol_i)+" group by DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%d.%m.%Y:%H'))group by Tag_Stunde;\n"
    cur.execute(e)
    e = "create or replace view MIN_H_" +str(symbol_i) + " as select DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%d.%m.%Y:%H') as Tag_Stunde,  DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%H:%i') as Uhrzeit, min(price) as minp from " + str(symbol_i)  + " where (price, DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%d.%m.%Y:%H')) in (Select min(price), DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%d.%m.%Y:%H') from " + str(symbol_i)  + " group by DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%d.%m.%Y:%H'))group by Tag_Stunde;\n"
    cur.execute(e)
    e = "create or replace view MAX" + str(symbol_i) + " as select DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%d.%m.%Y') as Tag,  DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%H:%i') as Uhrzeit, max(price) as maxp from "+ str(symbol_i)+" where (price, DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%d.%m.%Y')) in (Select max(price), DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%d.%m.%Y') from " + str(symbol_i) + " group by DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%d.%m.%Y'))group by Tag;\n"
    cur.execute(e)
    e = "create or replace view MIN" + str(symbol_i) + " as select DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%d.%m.%Y') as Tag, DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%H:%i') as Uhrzeit,  min(price) as minp from "+ str(symbol_i)+" where (price, DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%d.%m.%Y')) in (Select min(price), DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%d.%m.%Y') from " + str(symbol_i) + " group by DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%d.%m.%Y'))group by Tag;\n"
    cur.execute(e)
    e = " create or replace view AVG" + str(symbol_i) + " as select DATE_FORMAT(ADDDATE(datum, INTERVAL 2 HOUR), '%d.%m.%Y')as Tag, avg(price) as AVGP from " + str(symbol_i) + " group by Tag;\n"
    cur.execute(e)
    con.commit()

def log(time_l):
    con = mariadb.connect(user=user, password=password, host=host, database=database)
    cur = con.cursor()
    e = "UPDATE log SET time = '" + str(time_l) +"' WHERE ID = 1;"
    cur.execute(e)
    con.commit()
        
def insert(price_i, date_i, symbol_i, volume_24h, volume_change_24h , percent_change_1h, percent_change_24h, percent_change_7d, percent_change_30d, percent_change_60d,percent_change_90d,market_cap,market_cap_dominance,cmc_rank):
    con = mariadb.connect(user=user, password=password, host=host, database=database)
    cur = con.cursor()
    a = price_i
    b = date_i
    c = b.replace('T', ' ')
    d = c.replace('Z', '')
    if symbol_i == 'BTC':
        print("BTC_insert")
        a = round(a)
        e = 'INSERT INTO btc (price, datum, volume_24h, volume_change_24h , percent_change_1h, percent_change_24h, percent_change_7d, percent_change_30d, percent_change_60d,percent_change_90d,market_cap,market_cap_dominance, cmc_rank) VALUES (' + str(a) + ",'" + str(d) + "'," + volume_24h+ "," + volume_change_24h + "," + percent_change_1h+ "," + percent_change_24h+ "," + percent_change_7d+ "," + percent_change_30d+ "," + percent_change_60d+ "," +percent_change_90d+ "," +market_cap+ "," +market_cap_dominance +"," +cmc_rank+ ")"
        #print(e)        
        cur.execute(e)
        con.commit()
    elif symbol_i == 'ETH':
        a = round(a)
        print("ETH_insert")
        e = 'INSERT INTO eth (price, datum, volume_24h, volume_change_24h , percent_change_1h, percent_change_24h, percent_change_7d, percent_change_30d, percent_change_60d,percent_change_90d,market_cap,market_cap_dominance, cmc_rank) VALUES (' + str(a) + ",'" + str(d) + "'," + volume_24h+ "," + volume_change_24h + "," + percent_change_1h+ "," + percent_change_24h+ "," + percent_change_7d+ "," + percent_change_30d+ "," + percent_change_60d+ "," +percent_change_90d+ "," +market_cap+ "," +market_cap_dominance +"," +cmc_rank+ ")"
        cur.execute(e)
        con.commit()
    elif symbol_i == 'BNB':
        a = round(a)
        print('BNB!_insert')
        e = 'INSERT INTO bnb (price, datum, volume_24h, volume_change_24h , percent_change_1h, percent_change_24h, percent_change_7d, percent_change_30d, percent_change_60d,percent_change_90d,market_cap,market_cap_dominance, cmc_rank) VALUES (' + str(a) + ",'" + str(d) + "'," + volume_24h+ "," + volume_change_24h + "," + percent_change_1h+ "," + percent_change_24h+ "," + percent_change_7d+ "," + percent_change_30d+ "," + percent_change_60d+ "," +percent_change_90d+ "," +market_cap+ "," +market_cap_dominance +"," +cmc_rank+ ")"
        cur.execute(e)
        con.commit()
    elif symbol_i == 'MATIC':
        print('Matic!_insert')
        e = 'INSERT INTO matic (price, datum, volume_24h, volume_change_24h , percent_change_1h, percent_change_24h, percent_change_7d, percent_change_30d, percent_change_60d,percent_change_90d,market_cap,market_cap_dominance, cmc_rank) VALUES (' + str(a) + ",'" + str(d) + "'," + volume_24h+ "," + volume_change_24h + "," + percent_change_1h+ "," + percent_change_24h+ "," + percent_change_7d+ "," + percent_change_30d+ "," + percent_change_60d+ "," +percent_change_90d+ "," +market_cap+ "," +market_cap_dominance +"," +cmc_rank+ ")"
        cur.execute(e)
        con.commit()
    elif symbol_i == 'DOGE':
        print('Doge!_insert')
        e = 'INSERT INTO doge (price, datum, volume_24h, volume_change_24h , percent_change_1h, percent_change_24h, percent_change_7d, percent_change_30d, percent_change_60d,percent_change_90d,market_cap,market_cap_dominance, cmc_rank) VALUES (' + str(a) + ",'" + str(d) + "'," + volume_24h+ "," + volume_change_24h + "," + percent_change_1h+ "," + percent_change_24h+ "," + percent_change_7d+ "," + percent_change_30d+ "," + percent_change_60d+ "," +percent_change_90d+ "," +market_cap+ "," +market_cap_dominance +"," +cmc_rank+ ")"
        cur.execute(e)
        con.commit()
    elif symbol_i == 'ATOM':
        print('Atom!_insert')
        e = 'INSERT INTO atom (price, datum, volume_24h, volume_change_24h , percent_change_1h, percent_change_24h, percent_change_7d, percent_change_30d, percent_change_60d,percent_change_90d,market_cap,market_cap_dominance, cmc_rank) VALUES (' + str(a) + ",'" + str(d) + "'," + volume_24h+ "," + volume_change_24h + "," + percent_change_1h+ "," + percent_change_24h+ "," + percent_change_7d+ "," + percent_change_30d+ "," + percent_change_60d+ "," +percent_change_90d+ "," +market_cap+ "," +market_cap_dominance +"," +cmc_rank+ ")"
        cur.execute(e)
        con.commit()
    elif symbol_i == 'WBTC':
        a = round(a)
        print('Wbtc!_insert')
        e = 'INSERT INTO wbtc (price, datum, volume_24h, volume_change_24h , percent_change_1h, percent_change_24h, percent_change_7d, percent_change_30d, percent_change_60d,percent_change_90d,market_cap,market_cap_dominance, cmc_rank) VALUES (' + str(a) + ",'" + str(d) + "'," + volume_24h+ "," + volume_change_24h + "," + percent_change_1h+ "," + percent_change_24h+ "," + percent_change_7d+ "," + percent_change_30d+ "," + percent_change_60d+ "," +percent_change_90d+ "," +market_cap+ "," +market_cap_dominance +"," +cmc_rank+ ")"
        cur.execute(e)
        con.commit()
    else:
        #e ='CREATE TABLE ' + str(symbol_i) + ' (price float, datum datetime)'
        print(str(symbol_i) + '_insert')
        e = 'INSERT INTO ' + str(symbol_i) + ' (price, datum, volume_24h, volume_change_24h , percent_change_1h, percent_change_24h, percent_change_7d, percent_change_30d, percent_change_60d,percent_change_90d,market_cap,market_cap_dominance, cmc_rank) VALUES (' + str(a) + ",'" + str(d) + "'," + volume_24h+ "," + volume_change_24h + "," + percent_change_1h+ "," + percent_change_24h+ "," + percent_change_7d+ "," + percent_change_30d+ "," + percent_change_60d+ "," +percent_change_90d+ "," +market_cap+ "," +market_cap_dominance +"," +cmc_rank+ ")"
        cur.execute(e)
        con.commit()
