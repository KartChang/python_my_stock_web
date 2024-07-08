
import datetime
import json
from enum import Enum
from dataclasses import dataclass
from app.model import baseModel
from app.utility_tools import function
from flask_babel import gettext

def __init__(self):
    self.UserData = UserData

@dataclass
class UserData:
    Id: int = 0
    Account: str = ''
    Name: str = ''
    EmployeeNo: str = ''
    Department: str = ''
    Sort: int = 0
    Status: Enum = 0
    CreateUserId: str = ''
    CreateTime: datetime.datetime = None
    UpdateUserId: str = ''
    UpdateTime: datetime.datetime = None
    PermissionGroupNameListStr: str = ''
    StatusName: str = ''
    CreateUserName: str = ''
    UpdateUserName: str = ''
    def __init__(self, obj:dict=None):
        if obj is not None:
            for key, value in obj.items():
                setattr(self, key, value)
    #     print("-> UserData")
    #     super(UserData, self).__init__()
    #     print("<- UserData")
        # self.Id = 0
        # self.Account = ''
        # self.Name = ''
        # self.EmployeeNo = ''
        # self.Department = ''
        # self.Sort = 0
        # self.Status = 0
        # self.CreateUserId = ''
        # self.CreateTime = None
        # self.UpdateUserId = ''
        # self.UpdateTime = None

    def updateAttr(self, obj:dict):
        for key, value in obj.items():
            setattr(self, key, value)


    def toJSON(self):
        return json.dumps(
            self,
            # default=lambda o: o.__dict__, 
            sort_keys=True,
            indent=4, 
            cls=baseModel.ComplexEncoder,
            default=function.obj_dict)

    def convert(self, Class):
        self.__class__ = Class
        print(self.__class__)
        return self.__new__(Class)
            
    class StatusOption(baseModel.MyEnum):
        # def __new__(cls, *args, **kwds):
        #     super().__new__(*args, **kwds)
        # def __init__(self, _: str, description: str = None):
        #     super().__init__(_, description)
        # def __str__(self):
        #     super().__init__()
        # def description(self):
        #     super().description()

        Disable = 0, gettext("StatusOption_Disable")
        Enable = 1, gettext("StatusOption_Enable")