
import datetime
import json
from enum import Enum
from dataclasses import dataclass
from flask_babel import gettext

def __init__(self):
    self.PermissionGroup = PermissionGroup

@dataclass
class PermissionGroup:
    Id: int = 0
    Name: str = ''
    Sort: int = 0
    Status: Enum = None
    CreateUserId: str = ''
    CreateTime: datetime.datetime = None
    UpdateUserId: str = ''
    UpdateTime: datetime.datetime = None
    StatusName: str = ''
    CreateUserName: str = ''
    UpdateUserName: str = ''
    # def __init__(self):
    #     self.StatusName = gettext('StatusOption_' + (self.StatusOption.Enable.name if self.Status == self.StatusOption.Enable.value else self.StatusOption.Disable.name))
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
    def toJSON(self):
        return json.dumps(
            self,
            default=lambda o: o.__dict__, 
            sort_keys=True,
            indent=4)
            
    class StatusOption(Enum):
        Disable = 0
        Enable = 1