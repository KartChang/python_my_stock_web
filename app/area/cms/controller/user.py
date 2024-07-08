import os
import logging
import inspect
import json
import pandas 
import numpy 
import struct
import datetime
from flask import request,render_template,flash,abort,url_for,redirect,session,Flask,g,jsonify
from app import app
from app.config import AppSettingsConfig
import app.area.cms.controller as baseController
from app.model import baseModel
from app.utility_tools import function
from app.view_models.cms.CMS_User_ViewModel import CMS_User as CMS_User_ViewModel
from app.repository.baseRepository import BaseRepository
from app.repository.my_stock.userRepository import UserRepository
from app.repository.my_stock.permissionGroupRepository import PermissionGroupRepository
from app.model.my_stock.UserData import UserData as UserData
from app.model.my_stock.PermissionGroup import PermissionGroup as PermissionGroup
# from babel.support import Translations
from flask_babel import gettext

controllerName = baseController.Get_Ctrl_Name(__file__)
areaName = baseController.Get_Area_Name(__file__)
_PageTitle = '帳號管理'


@app.route('/' + areaName + '/' + controllerName, methods=['POST','GET'])
@function.cms_login_required('CMS_User_Info', 'in_At_log_At_cms')
# @login_required
def index_At_user_At_cms():
    logging.error('index_At_user_At_cms')
    # print(inspect.stack()[0][3])
    if request.method == 'GET':
        model = CMS_User_ViewModel.In.ViewModel()
        model._PageTitle = _PageTitle
        model._AreaName = areaName
        model._CtrlName = controllerName
        model._ActName = inspect.stack()[0][3]
        return render_template('cms/user/index.html', model=model)

    QueryParame = CMS_User_ViewModel.In.QueryModel()
    QueryParame.draw = request.values.get('draw', type=int)
    QueryParame.start = request.values.get('start', type=int)
    QueryParame.length = request.values.get('length', type=int)
    QueryParame.GenerateBaseParameter(request.values)
    QueryParame.Account = request.values.get('Account', type=str)

    if request.values.get('act') != None and request.values.get('act') == 'getTotalLength':
        returnValues = baseModel.BaseDataTableRowCountAPIJsonModel()
        SqlExecResult, RowCount = UserRepository().AllCount(QueryParame)
        returnValues.result = baseModel.BaseAPISimpleJsonModel.ExecResultOption.Success
        returnValues.row_count = RowCount
        return json.dumps(returnValues, cls=baseModel.ComplexEncoder, default=vars)

    UserItems = [UserData]
    SqlExecResult, UserItems = UserRepository().AllByPage(QueryParame, UserData)
    # print('-------------------------------------')
    # print(UserItems)
    # print(json.dumps(UserItems, indent=2, cls=baseModel.ComplexEncoder, default=function.obj_dict))
    # print('-------------------------------------')

    # aaa = [{'Id': 3, 'Account': 'kart', 'Name': '張元鴻', 'EmployeeNo': 'A0749', 'Department': '資訊處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': datetime.datetime(2022, 8, 3, 12, 17, 19), 'UpdateUserId': '3 張元鴻', 'UpdateTime': datetime.datetime(2022, 8, 3,15, 57, 22)}, {'Id': 4, 'Account': 'jim', 'Name': '莊永吉', 'EmployeeNo': 'A0727', 'Department': '資訊處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': datetime.datetime(2022, 8, 3, 14, 10, 33), 'UpdateUserId': 'A0749 張元鴻', 'UpdateTime': datetime.datetime(2022, 8, 3, 14, 11, 11)}, {'Id': 5, 'Account': 'michael', 'Name': '鄧善元', 'EmployeeNo': 'A0728', 'Department': '資訊處', 'Sort': 99999,'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': datetime.datetime(2022, 8, 3, 14, 13, 1), 'UpdateUserId': '', 'UpdateTime': None},{'Id': 6, 'Account': 'justice096731', 'Name': '陳勇安', 'EmployeeNo': 'A0747', 'Department': '資訊處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': datetime.datetime(2022, 8, 3, 14, 13, 57), 'UpdateUserId': '', 'UpdateTime': None}, {'Id': 7, 'Account': 'stacy822', 'Name': '黃詩晴', 'EmployeeNo': 'A0665', 'Department': '行政處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': datetime.datetime(2022, 8, 3, 14, 15, 1), 'UpdateUserId': '', 'UpdateTime': None}, {'Id': 8, 'Account': 'julie', 'Name': '陳秋燕', 'EmployeeNo': 'A0073', 'Department': '行政處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': datetime.datetime(2022, 8, 3, 14, 15, 16), 'UpdateUserId': '', 'UpdateTime': None}]
    # print(json.dumps(aaa, indent=2, cls=baseModel.ComplexEncoder))

    # abc = [{'Id': 3, 'Account': 'kart', 'Name': '張元鴻', 'EmployeeNo': 'A0749', 'Department': '資訊處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': 'datetime.datetime(2022, 8, 3, 12, 17, 19)', 'UpdateUserId': '3 張元鴻', 'UpdateTime': 'datetime.datetime(2022, 8, 3, 15, 57, 22)'}, {'Id': 4, 'Account': 'jim', 'Name': '莊永吉', 'EmployeeNo': 'A0727', 'Department': '資訊處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': 'datetime.datetime(2022, 8, 3, 14, 10, 33)', 'UpdateUserId': 'A0749 張元鴻', 'UpdateTime': 'datetime.datetime(2022, 8, 3, 14, 11, 11)'}, {'Id': 5, 'Account': 'michael', 'Name': '鄧善元', 'EmployeeNo': 'A0728', 'Department': '資訊處', 'Sort': 99999,'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': 'datetime.datetime(2022, 8, 3, 14, 13, 1)', 'UpdateUserId': '', 'UpdateTime': None},{'Id': 6, 'Account': 'justice096731', 'Name': '陳勇安', 'EmployeeNo': 'A0747', 'Department': '資訊處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': 'datetime.datetime(2022, 8, 3, 14, 13, 57)', 'UpdateUserId': '', 'UpdateTime': None}, {'Id': 7, 'Account': 'stacy822', 'Name': '黃詩晴', 'EmployeeNo': 'A0665', 'Department': '行政處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': 'datetime.datetime(2022, 8, 3, 14, 15, 1)', 'UpdateUserId': '', 'UpdateTime': None}, {'Id': 8, 'Account': 'julie', 'Name': '陳秋燕', 'EmployeeNo': 'A0073', 'Department': '行政處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': 'datetime.datetime(2022, 8, 3, 14, 15, 16)', 'UpdateUserId': '', 'UpdateTime': None}]
    # print(json.dumps(abc, indent=2))

    returnValues = baseModel.BaseDataTableViewModel()
    returnValues.draw = QueryParame.draw
    returnValues.recordsTotal = len(UserItems)
    returnValues.recordsFiltered = len(UserItems)
    # returnValues.data = UserItems
    returnValues.data = json.loads(json.dumps(UserItems, indent=2, cls=baseModel.ComplexEncoder, default=function.obj_dict))

    # UserItems = [UserData(**UserItem) for UserItem in UserItems]
    
    return json.dumps(returnValues, cls=baseModel.ComplexEncoder, default=vars)

# def serialize(obj):
#     if isinstance(obj, tuple):
#         return {'__tuple__': True, 'items': list(obj)}
#     elif isinstance(obj, list):
#         return [serialize(item) for item in obj]
#     elif isinstance(obj, dict):
#         return {key: serialize(value) for key, value in obj.items()}
#     elif isinstance(obj, datetime.datetime):
#         return obj.strftime('%Y-%m-%d %H:%M:%S')
#     elif isinstance(obj, datetime.date):
#         return obj.strftime('%Y-%m-%d')
#     else:
#         return obj

# def deserialize(obj):
#     if isinstance(obj, list):
#         return [deserialize(item) for item in obj]
#     elif isinstance(obj, dict):
#         if '__tuple__' in obj:
#             return tuple(obj['items'])
#         else:
#             return {key: deserialize(value) for key, value in obj.items()}
#     else:
#         return obj

@app.route('/' + areaName + '/' + controllerName + '/add', methods=['POST','GET'])
@function.cms_login_required('CMS_User_Info', 'in_At_log_At_cms')
def add_At_user_At_cms(id):
    logging.error('add_At_user_At_cms:' + id)
    if request.method == 'GET':
        model = CMS_User_ViewModel.Detail.ViewModel()
        model._PageTitle = _PageTitle
        model._AreaName = areaName
        model._CtrlName = controllerName
        model._ActName = inspect.stack()[0][3]
        return render_template('cms/user/index.html', model=model)

    return '123'

@app.route('/' + areaName + '/' + controllerName + '/modify/<string:id>', methods=['POST','GET'])
@function.cms_login_required('CMS_User_Info', 'in_At_log_At_cms')
def modify_At_user_At_cms(id):
    logging.error('modify_At_user_At_cms:' + id)
    
    UserItem = UserData()
    SqlExecResult, UserItem = UserRepository().FindById(id, TargetClass=UserData)
    if SqlExecResult == False:
        return '<html><head><script>alert("操作失敗，請重新確認您所輸入的資訊。");history.go(-1);</script></head></html>'

    if request.method == 'GET':
        model = CMS_User_ViewModel.Detail.ViewModel(json.loads(UserItem.toJSON()))
        model._PageTitle = _PageTitle
        model._AreaName = areaName
        model._CtrlName = controllerName
        model._ActName = inspect.stack()[0][3]
        model._CRUD_Action = baseModel.CRUD_Action.Update
        
        UDAndPGMappingQueryParame = {}
        UDAndPGMappingQueryParame['UserDataId'] = model.Id
        SqlExecResult, UDAndPGMappingItems = BaseRepository(TableName='', DbConnParame=AppSettingsConfig.MySqlDbConn, DbType=baseModel.DbType.MySql).ExecSql(SqlStr="SELECT `PermissionGroupId` FROM `UDAndPGMapping` WHERE `UserDataId` = %(UserDataId)s ", QueryParame=UDAndPGMappingQueryParame)
        model.PermissionGroupIds = []
        for UDAndPGMappingItems in UDAndPGMappingItems:
            model.PermissionGroupIds.append(UDAndPGMappingItems['PermissionGroupId'])
            
        PermissionGroupQueryParame = PermissionGroup
        PermissionGroupQueryParame.Status = PermissionGroup.StatusOption.Enable.value
        SqlExecResult, model.PermissionGroupItems = PermissionGroupRepository().Find(PermissionGroupQueryParame, TargetClass=PermissionGroup)
        # request.babel_translations = Translations.load('D:\kart\Project\Python\python_my_stock_web\app\views\locales', ['zh_TW'])
        return render_template('cms/user/detail.jinja2', model=model, baseModel=baseModel, StatusOption=UserData.StatusOption)

    returnValue = baseModel.BaseAPIJsonModel()
    RequestValues = request.values.to_dict()
    UpdateParame = {}
    UpdateParame['Status'] = RequestValues['Status']
    UpdateParame['Name'] = RequestValues['Name']
    UpdateParame['EmployeeNo'] = RequestValues['EmployeeNo']
    UpdateParame['Department'] = RequestValues['Department']
    WhereParame = {}
    WhereParame['Id'] = id
    # UserItem.updateAttr(RequestValues)
    SqlExecResult = UserRepository().Update(WhereParame, UpdateParame)
    if SqlExecResult == False:
        return '<html><head><script>alert("操作失敗，請重新確認您所輸入的資訊。");history.go(-1);</script></head></html>'




    returnValue.result = baseModel.BaseAPISimpleJsonModel.ExecResultOption.Success
    return json.dumps(returnValue, default=vars)

    
@app.route('/' + areaName + '/' + controllerName + '/delete/<string:id>', methods=['POST','GET'])
@function.cms_login_required('CMS_User_Info', 'in_At_log_At_cms')
def delete_At_user_At_cms(id):
    logging.error('delete_At_user_At_cms:' + id)

    return '123'


# from enum import Enum
# class Status(Enum):
#     READY = "ready", "I'm ready to do whatever is needed"
#     ERROR = "error", "Something went wrong here"

#     def __new__(cls, *args, **kwds):
#         obj = object.__new__(cls)
#         obj._value_ = args[0]
#         return obj

#     # ignore the first param since it's already set by __new__
#     def __init__(self, _: str, description: str = None):
#         self._description_ = description

#     def __str__(self):
#         return self.value

#     # this makes sure that the description is read-only
#     @property
#     def description(self):
#         return self._description_