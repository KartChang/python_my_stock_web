
import logging
import json
from app.model import baseModel
from app.config import AppSettingsConfig
from app.repository.baseRepository import BaseRepository
from app.utility_tools import function as function
from app.model.my_stock.PermissionGroup import PermissionGroup as PermissionGroup

class PermissionGroupRepository(BaseRepository):
    DbConn = None
    TableName = 'PermissionGroup'
    DbConnParame = AppSettingsConfig.MySqlDbConn
    DbType = baseModel.DbType.MySql

    def __init__(self):
        super().__init__(self.TableName, self.DbConnParame, self.DbType)
        self.DbConn = super().GetDbConn()

        
    def AllByPage(self, QueryParame_Received, TargetClass):
        ExecResult = False
        RowItems = None
        SearchCondition = ''
        SqlStr = ''
        QueryParame = {}
        try:
            with self.GetDbConn() as DbConn:
                with DbConn.cursor() as cursor:
                    SearchCondition += "" if function.StringIsNullOrWhiteSpace(QueryParame_Received.Account) else f"AND `{self.TableName}`.`Account` LIKE %(Account)s "
                    QueryParame['Account'] = "" if function.StringIsNullOrWhiteSpace(QueryParame_Received.Account) else QueryParame_Received.Account.strip()

                    SqlStr = f"""SELECT * 
                    , (SELECT GROUP_CONCAT(`PermissionGroup`.`Name` SEPARATOR '、') FROM `UDAndPGMapping` LEFT JOIN `PermissionGroup` ON `PermissionGroup`.`Id` = `UDAndPGMapping`.`PermissionGroupId` WHERE `UserDataId` = `{self.TableName}`.`Id` ORDER BY `PermissionGroup`.`Id` ASC) AS 'PermissionGroupNameListStr' 
                    , CASE WHEN `{self.TableName}`.`Status` = 1 THEN '啟用' ELSE '停用' END AS `StatusName`
                    , `{self.TableName}`.`CreateUserId` AS `CreateUserName` 
                    , CASE WHEN `{self.TableName}`.`UpdateUserId` IS NOT NULL AND `{self.TableName}`.`UpdateUserId` != '' THEN`{self.TableName}`.`UpdateUserId` ELSE `{self.TableName}`.`CreateUserId` END AS `UpdateUserName` 
                    -- , CASE WHEN `{self.TableName}`.`UpdateTime` IS NOT NULL THEN`{self.TableName}`.`UpdateTime` ELSE `{self.TableName}`.`CreateTime` END AS `UpdateTime` 
                    FROM `{self.TableName}` 
                    WHERE 1 = 1 {SearchCondition}
                    ORDER BY `CreateTime`"""
                    # print(SqlStr)
                    cursor.execute(SqlStr, QueryParame)
                    # self.DbConn.commit()
                    RowItems = cursor.fetchall()
                    print('-------------------------------------')
                    RowItems = [TargetClass(**RowItem) for RowItem in RowItems]
                    print('-------------------------------------')
                    # print(RowItems)
                    # logging.error(json.dumps(RowItems, cls=baseModel.ComplexEncoder))
                    # RowItemsLength = len(RowItems)
                    # logging.error(f'len(RowItems): {len(RowItems)}')
                    ExecResult = True
        except Exception as ex:
            logging.error(ex)
        
        return ExecResult, RowItems
        
    def AllCount(self, QueryParame_Received):
        ExecResult = False
        RowCount = 0
        SearchCondition = ''
        SqlStr = ''
        QueryParame = {}
        try:
            with self.GetDbConn() as DbConn:
                with DbConn.cursor() as cursor:
                    SearchCondition += "" if function.StringIsNullOrWhiteSpace(QueryParame_Received.Account) else f"AND `{self.TableName}`.`Account` LIKE %(Account)s "
                    QueryParame['Account'] = "" if function.StringIsNullOrWhiteSpace(QueryParame_Received.Account) else QueryParame_Received.Account.strip()

                    SqlStr = f"""SELECT COUNT(*) AS `Count`
                    FROM `{self.TableName}` 
                    WHERE 1 = 1 {SearchCondition} """
                    # print(SqlStr)
                    cursor.execute(SqlStr, QueryParame)
                    # self.DbConn.commit()
                    RowCount = int(cursor.fetchone()['Count'])
                    # print('-------------------------------------')
                    # print(RowCount)
                    # logging.error(json.dumps(RowItems, cls=baseModel.ComplexEncoder))
                    # RowItemsLength = len(RowItems)
                    # logging.error(f'len(RowItems): {len(RowItems)}')
                    ExecResult = True
        except Exception as ex:
            logging.error(ex)
        
        return ExecResult, RowCount



    def Find(self, QueryParame_Received: PermissionGroup, TargetClass):
        ExecResult = False
        RowItems = None
        SearchCondition = ''
        SqlStr = ''
        QueryParame = {}
        try:
            with self.GetDbConn() as DbConn:
                with DbConn.cursor() as cursor:
                    SearchCondition += "" if QueryParame_Received.Status == None else f"AND `{self.TableName}`.`Status` = %(Status)s "
                    QueryParame['Status'] = "" if QueryParame_Received.Status == None else QueryParame_Received.Status

                    SqlStr = f"""SELECT * 
                    , `{self.TableName}`.`CreateUserId` AS `CreateUserName` 
                    FROM `{self.TableName}` 
                    WHERE 1 = 1 {SearchCondition}
                    ORDER BY `CreateTime`"""
                    # print(SqlStr)
                    cursor.execute(SqlStr, QueryParame)
                    # self.DbConn.commit()
                    RowItems = cursor.fetchall()
                    # print(RowItems)
                    # print('-------------------------------------')
                    RowItems = [TargetClass(**RowItem) for RowItem in RowItems]
                    # print('-------------------------------------')
                    # print(RowItems)
                    # logging.error(json.dumps(RowItems, cls=baseModel.ComplexEncoder))
                    # RowItemsLength = len(RowItems)
                    # logging.error(f'len(RowItems): {len(RowItems)}')
                    ExecResult = True
        except Exception as ex:
            logging.error(ex)
        
        return ExecResult, RowItems

    # def FindById(self, id, idName = 'Id'):
    #     super().FindById(id, idName)