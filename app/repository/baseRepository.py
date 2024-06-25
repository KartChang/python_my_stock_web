import pymysql
import pymssql
import logging
import json
from app.model import baseMode

def CursorByName(self):
    result = self.fetchall()
    rowItems = []
    for row in result:
        rowItems.append({ description[0]: row[col] for col, description in enumerate(self.description) })
    return rowItems

class BaseRepository:
    DbConn = None
    TableName = ''
    DbConnParame = None
    DbType = None

    def __init__(self, TableName, DbConnParame, DbType):
        self.TableName = TableName
        self.DbConnParame = DbConnParame
        self.DbType = DbType

    def GetDbConn(self):
        if self.DbType == baseMode.DbType.MySql:
            DbConn = pymysql.connect(host=self.DbConnParame.DbHost, port=self.DbConnParame.DbPort, user=self.DbConnParame.DbUser, password=self.DbConnParame.DbPassword, database=self.DbConnParame.DbName, charset='utf8', connect_timeout=30, read_timeout=7200, cursorclass=pymysql.cursors.DictCursor)
            # DbConn.cursor().fetchall
            return DbConn
        elif self.DbType == baseMode.DbType.MySql:
            DbConn = pymssql.connect(server=self.DbConnParame.DbHost, port=self.DbConnParame.DbPort, user=self.DbConnParame.DbUser, password=self.DbConnParame.DbPassword, database=self.DbConnParame.DbName, timeout=7200, login_timeout=30)
            return DbConn
        else:
            return None

    def FindById(self, id, idName = 'Id'):
        ExecResult = False
        RowItem = None
        try:
            with self.DbConn.cursor() as cursor:
                SqlStr = f"SELECT * FROM `" + self.TableName + "` WHERE `" + idName + "` = %(" + idName + ")s "
                QueryParame = {}
                QueryParame[idName] = id
                cursor.execute(SqlStr, {idName:id})
                # self.DbConn.commit()
                RowItem = cursor.fetchone()
                # RowItem = CursorByName(cursor)[0]
                # print(RowItem)
                ExecResult = True
        except Exception as ex:
            logging.error(ex)
        
        return ExecResult, RowItem

    # def Find(self, QueryParame):
    #     cursor = DbConn.cursor()
    #     querystr = "INSERT INTO [StockDailyLog] ([CreateTime], [Code], [Name], [TradeValume], [TradePrice], [OpenPrice], [TopPrice], [LowPrice], [ClosePrice], [PriceDiff], [TradeCount]) VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
    #     cursor.executemany(querystr, QueryParame)