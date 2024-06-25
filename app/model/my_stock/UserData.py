
import datetime
from dataclasses import dataclass


@dataclass
class User:
    Id: int = 0
    Account: str = ''
    Name: str = ''
    EmployeeNo: str = ''
    Department: str = ''
    Sort: int = 0
    Status: int = 0
    CreateUserId: str = ''
    CreateTime: datetime.datetime = None
    UpdateUserId: str = ''
    UpdateTime: datetime.datetime = None
    PermissionGroupNameListStr: str = ''
    StatusName: str = ''
    CreateUserName: str = ''
    UpdateUserName: str = ''
    # def __init__(self):
    #     self.Id = 0
    #     self.Account = ''
    #     self.Name = ''
    #     self.EmployeeNo = ''
    #     self.Department = ''
    #     self.Sort = 0
    #     self.Status = 0
    #     self.CreateUserId = ''
    #     self.CreateTime = None
    #     self.UpdateUserId = ''
    #     self.UpdateTime = None


UserData = User()