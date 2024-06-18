
from app.repository import baseRespository

DbConn = None
TableName = 'Stock'

def __init__():
    DbConn = baseRespository.GetDbConn(TableName, DbHost, DbPort, DbUser, DbPassword, DbName, DbType)

def Find(QueryParame):
    DbConn = defDb.connect(server='127.0.0.1', port='9510', user='kart', password='kart0813', database='KC_Edu_Test', timeout=7200)
 
 
    cursor = DbConn.cursor()
    
    
    querystr = "INSERT INTO [StockDailyLog] ([CreateTime], [Code], [Name], [TradeValume], [TradePrice], [OpenPrice], [TopPrice], [LowPrice], [ClosePrice], [PriceDiff], [TradeCount]) VALUES(%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
    
    cursor.executemany(querystr, QueryParame)