
import app.model.baseModel as baseModel
from app.model.my_stock.UserData import UserData as UserData
from app.model.my_stock.PermissionGroup import PermissionGroup as PermissionGroup

class CMS_User:
    class In:
        class ViewModel(baseModel.BaseViewModel):
            def __init__(self):
                super().__init__()
                self.Account = ''

            def __str__(self):
                return str(self.__class__) + ": " + str(self.__dict__)
                
        class QueryModel(baseModel.BaseQueryModel):
            def __init__(self):
                super().__init__()
                self.Account = ''

            def __str__(self):
                return str(self.__class__) + ": " + str(self.__dict__)

                
    class Detail:
        class ViewModel(baseModel.BaseViewModel, UserData):
            def __init__(self, obj:dict=None):
                super().__init__()
                if obj is not None:
                    for key, value in obj.items():
                        setattr(self, key, value)
                # parent.__init__(self)
                self.PermissionGroupItems = [PermissionGroup]
                self.PermissionGroupIds = []

            def convert(self, Class):
                self.__class__ = Class
                print(self.__class__)
                return self.__new__(Class)

            def __str__(self):
                return str(self.__class__) + ": " + str(self.__dict__)
                
            def update(self, obj):
                for key, value in obj.items():
                    setattr(self, key, value)
                
        class QueryModel(UserData):
            def __init__(self):
                super().__init__()
                self.Account = ''

            def __str__(self):
                return str(self.__class__) + ": " + str(self.__dict__)