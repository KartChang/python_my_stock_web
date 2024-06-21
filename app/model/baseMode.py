import json
from datetime import date, datetime


class CMS_QueryModel:
    def __init__(self):
        self.ajax = ''
        self.draw = None
        self.start = None
        self.length = None
        self.total_length = None
        self.order = {'column':[], 'sort':[], 'sort_asc':[]}
        self.columns = []
    def __str__(self):
        return str(self.__class__) + ": " + str(self.__dict__)

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