import json
from datetime import date, datetime


class DbType:
    Sqlsrv = 1,
    MySql = 2,
    Oracle = 3

class ComplexEncoder(json.JSONEncoder):
    def  default(self, obj):
        if isinstance(obj, datetime):
            return obj.strftime('%Y-%m-%d %H:%M:%S')
        elif isinstance(obj, datetime):
            return obj.strftime('%Y-%m-%d')
        else:
            return json.JSONEncoder.default(self, obj)