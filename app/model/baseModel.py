import json
from enum import Enum
from datetime import date, datetime
from flask_babel import gettext


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

class MyEnum(Enum):
    def __new__(cls, *args, **kwds):
        obj = object.__new__(cls)
        obj._value_ = args[0]
        return obj

    # ignore the first param since it's already set by __new__
    def __init__(self, _: str, description: str = None):
        self._description_ = description

    def __str__(self):
        return self.value

    # this makes sure that the description is read-only
    @property
    def description(self):
        return gettext(self._description_)

class DbType(MyEnum):
    Sqlsrv = 1, "DbType_Sqlsrv"
    MySql = 2, "DbType_MySql"
    Oracle = 3, "DbType_Oracle"
    
class CRUD_Action(MyEnum):
    Create = 1, "CRUD_Action_Create"
    Read = 2, "CRUD_Action_Read"
    Update = 3, "CRUD_Action_Update"
    Delete = 4, "CRUD_Action_Delete"
    Export = 5, "CRUD_Action_Export"


class ComplexEncoder(json.JSONEncoder):
    def  default(self, obj):
        if isinstance(obj, datetime):
            return obj.strftime('%Y-%m-%d %H:%M:%S')
        elif isinstance(obj, datetime):
            return obj.strftime('%Y-%m-%d')
        else:
            return json.JSONEncoder.default(self, obj)

class BaseViewModel:
    def __init__(self):
        self._PageTitle = ''
        self._AreaName = ''
        self._CtrlName = ''
        self._ActName = ''
        self._CRUD_Action = CRUD_Action.Read


class BaseAPISimpleJsonModel:
    def __init__(self):
        self.result = self.ExecResultOption.Fail
        self.msg = ""

    class ExecResultOption:
        Fail = 0, "ExecResult_Fail"
        Success = 1, "ExecResult_Success"


class BaseAPIJsonModel(BaseAPISimpleJsonModel):
    def __init__(self):
        super().__init__()
        self.fields_err_msg = {}

class BaseQueryModel:
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

    def GenerateBaseParameter(self, request_values):
        for key, value in request_values.items():
            if key.lower().find('columns') == 0:
                _columnNameArr = key.replace(']', '').split('[')
                if _columnNameArr[2] == 'name':
                    self.columns.append({'name':value,'data':request_values.get('columns[' + _columnNameArr[1] + '][data]'),'searchable':request_values.get('columns[' + _columnNameArr[1] + '][searchable]'),'orderable':request_values.get('columns[' + _columnNameArr[1] + '][orderable]')})
            elif key.lower().find('order') == 0:
                _columnNameArr = key.replace(']', '').split('[')
                if _columnNameArr[2] == 'column':
                    self.order['column'].append(request_values.get('columns[' + value + '][name]'))
                    self.order['sort'].append(request_values.get('order[' + _columnNameArr[1] + '][dir]'))
                    self.order['sort_asc'].append(True if request_values.get('order[' + _columnNameArr[1] + '][dir]') == 'asc' else False)

class BaseDataTableRowCountAPIJsonModel(BaseAPIJsonModel):
    def __init__(self):
        super().__init__()
        self.row_count = 0
    def __str__(self):
        return str(self.__class__) + ": " + str(self.__dict__)

class BaseDataTableViewModel:
    def __init__(self):
        self.draw = 0
        self.recordsTotal = 0
        self.recordsFiltered = 0
        self.data = []
    def __str__(self):
        return str(self.__class__) + ": " + str(self.__dict__)