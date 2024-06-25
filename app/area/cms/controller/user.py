import os
import logging
import inspect
import json
import pandas 
import numpy 
import struct
from flask import request,render_template,flash,abort,url_for,redirect,session,Flask,g,jsonify
from app import app
import app.area.cms.controller as baseController
from app.model import baseMode
from app.utility_tools import function
from app.view_models.cms.CMS_User_ViewModel import CMS_User as CMS_User_ViewModel
from app.repository.my_stock.userRepository import UserRepository
from app.model.my_stock.UserData import User as UserData
# from flask_login import login_required

import datetime

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
        model.PageTitle = _PageTitle
        model.CtrlName = controllerName
        model.ActName = inspect.stack()[0][3]
        return render_template('cms/user/index.html', model=model)

    QueryParame = CMS_User_ViewModel.In.QueryModel()
    QueryParame.draw = request.values.get('draw', type=int)
    QueryParame.start = request.values.get('start', type=int)
    QueryParame.length = request.values.get('length', type=int)
    QueryParame.GenerateBaseParameter(request.values)
    QueryParame.Account = request.values.get('Account', type=str)

    if request.values.get('act') != None and request.values.get('act') == 'getTotalLength':
        returnValues = baseMode.BaseDataTableRowCountAPIJsonModel()
        SqlExecResult, RowCount = UserRepository().AllCount(QueryParame)
        returnValues.result = baseMode.BaseAPISimpleJsonModel.ExecResultOption.Success
        returnValues.row_count = RowCount
        return json.dumps(returnValues, cls=baseMode.ComplexEncoder, default=vars)

    UserItems = [UserData]
    SqlExecResult, UserItems = UserRepository().AllByPage(QueryParame, UserItems)
    # print(UserItems)
    # print(json.dumps(UserItems, indent=2))
    # print(json.dumps(UserItems, indent=2, cls=baseMode.ComplexEncoder))

    # aaa = [{'Id': 3, 'Account': 'kart', 'Name': '張元鴻', 'EmployeeNo': 'A0749', 'Department': '資訊處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': datetime.datetime(2022, 8, 3, 12, 17, 19), 'UpdateUserId': '3 張元鴻', 'UpdateTime': datetime.datetime(2022, 8, 3,15, 57, 22)}, {'Id': 4, 'Account': 'jim', 'Name': '莊永吉', 'EmployeeNo': 'A0727', 'Department': '資訊處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': datetime.datetime(2022, 8, 3, 14, 10, 33), 'UpdateUserId': 'A0749 張元鴻', 'UpdateTime': datetime.datetime(2022, 8, 3, 14, 11, 11)}, {'Id': 5, 'Account': 'michael', 'Name': '鄧善元', 'EmployeeNo': 'A0728', 'Department': '資訊處', 'Sort': 99999,'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': datetime.datetime(2022, 8, 3, 14, 13, 1), 'UpdateUserId': '', 'UpdateTime': None},{'Id': 6, 'Account': 'justice096731', 'Name': '陳勇安', 'EmployeeNo': 'A0747', 'Department': '資訊處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': datetime.datetime(2022, 8, 3, 14, 13, 57), 'UpdateUserId': '', 'UpdateTime': None}, {'Id': 7, 'Account': 'stacy822', 'Name': '黃詩晴', 'EmployeeNo': 'A0665', 'Department': '行政處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': datetime.datetime(2022, 8, 3, 14, 15, 1), 'UpdateUserId': '', 'UpdateTime': None}, {'Id': 8, 'Account': 'julie', 'Name': '陳秋燕', 'EmployeeNo': 'A0073', 'Department': '行政處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': datetime.datetime(2022, 8, 3, 14, 15, 16), 'UpdateUserId': '', 'UpdateTime': None}]
    # print(json.dumps(aaa, indent=2, cls=baseMode.ComplexEncoder))

    # abc = [{'Id': 3, 'Account': 'kart', 'Name': '張元鴻', 'EmployeeNo': 'A0749', 'Department': '資訊處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': 'datetime.datetime(2022, 8, 3, 12, 17, 19)', 'UpdateUserId': '3 張元鴻', 'UpdateTime': 'datetime.datetime(2022, 8, 3, 15, 57, 22)'}, {'Id': 4, 'Account': 'jim', 'Name': '莊永吉', 'EmployeeNo': 'A0727', 'Department': '資訊處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': 'datetime.datetime(2022, 8, 3, 14, 10, 33)', 'UpdateUserId': 'A0749 張元鴻', 'UpdateTime': 'datetime.datetime(2022, 8, 3, 14, 11, 11)'}, {'Id': 5, 'Account': 'michael', 'Name': '鄧善元', 'EmployeeNo': 'A0728', 'Department': '資訊處', 'Sort': 99999,'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': 'datetime.datetime(2022, 8, 3, 14, 13, 1)', 'UpdateUserId': '', 'UpdateTime': None},{'Id': 6, 'Account': 'justice096731', 'Name': '陳勇安', 'EmployeeNo': 'A0747', 'Department': '資訊處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': 'datetime.datetime(2022, 8, 3, 14, 13, 57)', 'UpdateUserId': '', 'UpdateTime': None}, {'Id': 7, 'Account': 'stacy822', 'Name': '黃詩晴', 'EmployeeNo': 'A0665', 'Department': '行政處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': 'datetime.datetime(2022, 8, 3, 14, 15, 1)', 'UpdateUserId': '', 'UpdateTime': None}, {'Id': 8, 'Account': 'julie', 'Name': '陳秋燕', 'EmployeeNo': 'A0073', 'Department': '行政處', 'Sort': 99999, 'Status': 1, 'CreateUserId': 'A0749 張元鴻', 'CreateTime': 'datetime.datetime(2022, 8, 3, 14, 15, 16)', 'UpdateUserId': '', 'UpdateTime': None}]
    # print(json.dumps(abc, indent=2))

    returnValues = baseMode.BaseDataTableViewModel()
    returnValues.draw = QueryParame.draw
    returnValues.recordsTotal = len(UserItems)
    returnValues.recordsFiltered = len(UserItems)
    returnValues.data = UserItems
    returnValues.data = json.loads(json.dumps(UserItems, indent=2, cls=baseMode.ComplexEncoder))

    # UserItems = [UserData(**UserItem) for UserItem in UserItems]
    
    return json.dumps(returnValues, cls=baseMode.ComplexEncoder, default=vars)

def serialize(obj):
    if isinstance(obj, tuple):
        return {'__tuple__': True, 'items': list(obj)}
    elif isinstance(obj, list):
        return [serialize(item) for item in obj]
    elif isinstance(obj, dict):
        return {key: serialize(value) for key, value in obj.items()}
    elif isinstance(obj, datetime.datetime):
        return obj.strftime('%Y-%m-%d %H:%M:%S')
    elif isinstance(obj, datetime.date):
        return obj.strftime('%Y-%m-%d')
    else:
        return obj

def deserialize(obj):
    if isinstance(obj, list):
        return [deserialize(item) for item in obj]
    elif isinstance(obj, dict):
        if '__tuple__' in obj:
            return tuple(obj['items'])
        else:
            return {key: deserialize(value) for key, value in obj.items()}
    else:
        return obj


@app.route('/' + areaName + '/' + controllerName + '/modify/<string:id>', methods=['POST','GET'])
@function.cms_login_required('CMS_User_Info', 'in_At_log_At_cms')
def modify_At_user_At_cms(id):
    logging.error('modify_At_user_At_cms:' + id)
    if request.method == 'GET':
        model = CMS_User_ViewModel.Detail.ViewModel()
        model.PageTitle = _PageTitle
        model.CtrlName = controllerName
        model.ActName = inspect.stack()[0][3]
        return render_template('cms/user/index.html', model=model)

    return '123'

    
@app.route('/' + areaName + '/' + controllerName + '/delete/<string:id>', methods=['POST','GET'])
@function.cms_login_required('CMS_User_Info', 'in_At_log_At_cms')
def delete_At_user_At_cms(id):
    logging.error('delete_At_user_At_cms:' + id)

    return '123'




