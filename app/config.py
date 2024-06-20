
import json

class Dict(dict):
    """dot.notation access to dictionary attributes"""
    __getattr__ = dict.__getitem__
    __setattr__ = dict.__setitem__
    __delattr__ = dict.__delitem__

class Config(object):
    @staticmethod
    def __load__(data):
        if type(data) is dict:
            return Config.load_dict(data)
        elif type(data) is list:
            return Config.load_list(data)
        else:
            return data

    @staticmethod
    def load_dict(data: dict):
        result = Dict()
        for key, value in data.items():
            result[key] = Config.__load__(value)
        return result

    @staticmethod
    def load_list(data: list):
        result = [Config.__load__(item) for item in data]
        return result

    @staticmethod
    def load_json(path: str):
        with open(path, "r") as f:
            result = Config.__load__(json.loads(f.read()))
        return result





# class DbCondnParame:
#     def __init__(self, DbHost, DbPort, DbUser, DbPassword, DbName):
#         self.DbHost = DbHost
#         self.DbPort = DbPort
#         self.DbUser = DbUser
#         self.DbPassword = DbPassword
#         self.DbName = DbName

# DefaultDbConnParame = DbCondnParame(DbHost='', DbPort='', DbUser='', DbPassword='', DbName='')

AppSettingsConfig = Config.load_json('appsettings.json')

# DbConn = defDb.connect(server='127.0.0.1', port='9510', user='kart', password='kart0813', database='KC_Edu_Test', timeout=7200)