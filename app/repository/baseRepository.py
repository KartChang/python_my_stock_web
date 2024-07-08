import pymysql
import pymssql
import logging
import json
from app.model import baseModel
from app.utility_tools import function

def CursorByName(self):
    result = self.fetchall()
    rowItems = []
    for row in result:
        rowItems.append({ description[0]: row[col] for col, description in enumerate(self.description) })
    return rowItems

class BaseRepository:
    TableName = ''
    DbConnParame = None
    DbType = None

    def __init__(self, TableName, DbConnParame, DbType):
        self.TableName = TableName
        self.DbConnParame = DbConnParame
        self.DbType = DbType

    def GetDbConn(self):
        if self.DbType == baseModel.DbType.MySql:
            DbConn = pymysql.connect(host=self.DbConnParame.DbHost, port=self.DbConnParame.DbPort, user=self.DbConnParame.DbUser, password=self.DbConnParame.DbPassword, database=self.DbConnParame.DbName, charset='utf8', connect_timeout=30, read_timeout=7200, cursorclass=pymysql.cursors.DictCursor)
            # DbConn.cursor().fetchall
            return DbConn
        elif self.DbType == baseModel.DbType.MySql:
            DbConn = pymssql.connect(server=self.DbConnParame.DbHost, port=self.DbConnParame.DbPort, user=self.DbConnParame.DbUser, password=self.DbConnParame.DbPassword, database=self.DbConnParame.DbName, timeout=7200, login_timeout=30)
            return DbConn
        else:
            return None
            
    def ExecSql(self, SqlStr, QueryParame, TargetClass = None):
        ExecResult = False
        RowItems = None
        try:
            with self.GetDbConn() as DbConn:
                with DbConn.cursor() as cursor:
                    # print(SqlStr)
                    # print(QueryParame)
                    cursor.execute(SqlStr, QueryParame)
                    # print('------------------------------------------------------------------')
                    # self.DbConn.commit()
                    RowItems = cursor.fetchall()
                    # print(RowItems)
                    # print(TargetClass)
                    if TargetClass != None:
                        RowItems = [TargetClass(**RowItem) for RowItem in RowItems]
                    # print('------------------------------------------------------------------')
                    # RowItem = CursorByName(cursor)[0]
                    # print(RowItem)
                    ExecResult = True
        except Exception as ex:
            logging.error(ex)
        
        return ExecResult, RowItems

    def FindById(self, id, idName = 'Id', TargetClass = None):
        ExecResult = False
        RowItem = None
        try:
            with self.GetDbConn() as DbConn:
                with DbConn.cursor() as cursor:
                    SqlStr = f"SELECT * FROM `" + self.TableName + "` WHERE `" + idName + "` = %(" + idName + ")s "
                    QueryParame = {}
                    QueryParame[idName] = id
                    # print(SqlStr)
                    # print(QueryParame)
                    cursor.execute(SqlStr, {idName:id})
                    # print('------------------------------------------------------------------')
                    # self.DbConn.commit()
                    RowItem = cursor.fetchone()
                    # print(RowItem)
                    # print(TargetClass)
                    if TargetClass != None:
                        RowItem = TargetClass(RowItem)
                    # RowItem = CursorByName(cursor)[0]
                    # print(RowItem)
                    ExecResult = True
        except Exception as ex:
            logging.error(ex)
        
        return ExecResult, RowItem
        

    def Update(self, WhereParame, UpdateParame):
        ExecResult = False
        RowItem = None
        UpdateStatement = ''
        SearchCondition = ''
        SqlStr = ''
        QueryParame = {}
        try:
            with self.GetDbConn() as DbConn:
                with DbConn.cursor() as cursor:
                    for Parame in UpdateParame:
                        UpdateStatement += f", `{self.TableName}`.`{Parame}` = %({Parame})s \n"
                    for Parame in WhereParame:
                        SearchCondition += f"AND `{self.TableName}`.`{Parame}` = %({Parame})s \n"
                    UpdateStatement = UpdateStatement[2:] if len(UpdateStatement) > 0 else ''
                    SearchCondition = SearchCondition[4:] if len(SearchCondition) > 0 else ''

                    if function.StringIsNullOrWhiteSpace(UpdateStatement) is not True and function.StringIsNullOrWhiteSpace(UpdateStatement) is not True:
                        SqlStr = f"""
                        UPDATE `{self.TableName}` SET {UpdateStatement} 
                        WHERE {SearchCondition}  """
                        # print(SqlStr)
                        cursor.execute(SqlStr, {**UpdateParame, **WhereParame})
                        DbConn.commit()
                        ExecResult = True
        except Exception as ex:
            logging.error(ex)
        
        return ExecResult

    # def Find(self, QueryParame):
    #     cursor = DbConn.cursor()
    #     querystr = "INSERT INTO [StockDailyLog] ([CreateTime], [Code], [Name], [TradeValume], [TradePrice], [OpenPrice], [TopPrice], [LowPrice], [ClosePrice], [PriceDiff], [TradeCount]) VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
    #     cursor.executemany(querystr, QueryParame)