
class CMS_Log_In_QueryModel:
    # Account = ''
    # Password = ''
    def __init__(self):
        self.Account = ''
        self.Password = ''

    def __str__(self):
        return str(self.__class__) + ": " + str(self.__dict__)

    def ModelRequestCheck(self):
        FieldErrMsg = {}
        if self.Account == None or self.Account == '':
            FieldErrMsg['Account'] = '登入帳號 請填寫正確'
        if self.Password == None or self.Password == '':
            FieldErrMsg['Password'] = '登入密碼 請填寫正確'
        return FieldErrMsg == {}, FieldErrMsg