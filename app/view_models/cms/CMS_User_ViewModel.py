
import app.model.baseMode as baseModel

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