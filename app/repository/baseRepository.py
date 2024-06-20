import pymysql
import pymssql
from app.model import baseMode

class BaseRepository:
    TableName = ''
    DbConnParame = None
    DbType = None

    def __init__(self, TableName, DbConnParame, DbType):
        self.TableName = TableName
        self.DbConnParame = DbConnParame
        self.DbType = DbType

    def GetDbConn(self):
        if self.DbType == baseMode.DbType.MySql:
            return pymysql.connect(host=self.DbConnParame.DbHost, port=self.DbConnParame.DbPort, user=self.DbConnParame.DbUser, password=self.DbConnParame.DbPassword, database=self.DbConnParame.DbName, charset='utf8', connect_timeout=30, read_timeout=7200)
        elif self.DbType == baseMode.DbType.MySql:
            return pymssql.connect(server=self.DbConnParame.DbHost, port=self.DbConnParame.DbPort, user=_self.DbConnParame.DbUser, password=self.DbConnParame.DbPassword, database=self.DbConnParame.DbName, timeout=7200, login_timeout=30)
        else:
            return None

    # def Find(self, QueryParame):
    #     cursor = DbConn.cursor()
    #     querystr = "INSERT INTO [StockDailyLog] ([CreateTime], [Code], [Name], [TradeValume], [TradePrice], [OpenPrice], [TopPrice], [LowPrice], [ClosePrice], [PriceDiff], [TradeCount]) VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
    #     cursor.executemany(querystr, QueryParame)