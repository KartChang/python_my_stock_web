
import logging
import json
from app.model import baseMode
from app.config import AppSettingsConfig
from app.repository.baseRepository import BaseRepository


class StockRepository(BaseRepository):
    DbConn = None
    TableName = 'Stock'
    DbConnParame = AppSettingsConfig.MySqlDbConn
    DbType = baseMode.DbType.MySql

    def __init__(self):
        logging.info(json.dumps(AppSettingsConfig, cls=baseMode.ComplexEncoder))
        super().__init__(self.TableName, self.DbConnParame, self.DbType)
        # self.DbConn = super(StockRepository, self).GetDbConn()
        self.DbConn = super().GetDbConn()
        # self.DbConn = baseRespository.BaseRepository(TableName=TableName, DbConnParame=AppSettingsConfig.MySqlDbConn, DbType=baseMode.DbType.MySql).GetDbConn()

    def Find(self, QueryParame):
        cursor = self.DbConn.cursor()
        querystr = "SELECT * FROM `IPLeasesLog` ORDER BY `CreateTime` LIMIT 10"
        cursor.execute(querystr, QueryParame)
        return cursor.fetchall() 