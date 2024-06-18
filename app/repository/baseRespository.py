import pymysql
import pymssql
from app.model import baseMode

_TableName = ''
_DbHost = ''
_DbPort = ''
_DbUser = ''
_DbPassword = ''
_DbName = ''
_DbType = ''

def __init__(TableName, DbHost, DbPort, DbUser, DbPassword, DbName, DbType):
    _TableName = TableName
    _DbHost = DbHost
    _DbPort = DbPort
    _DbUser = DbUser
    _DbPassword = DbPassword
    _DbName = DbName
    _DbType = DbType

def GetDbConn():
    if _DbType == baseMode.DbType.MySql:
        return pymysql.connect(host=_DbHost, port=_DbPort, user=_DbUser, password=_DbPassword, database=_DbName, charset='utf8', connect_timeout=30, read_timeout=7200)
    elif _DbType == baseMode.DbType.MySql:
        return pymssql.connect(server=_DbHost, port=_DbPort, user=_DbUser, password=_DbPassword, database=_DbName, timeout=7200, login_timeout=30)
    else:
        return None