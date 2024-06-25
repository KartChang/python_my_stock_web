import os
import logging
import json
from flask import request,render_template,flash,abort,url_for,redirect,session,Flask,g,jsonify
from app import app
import app.area.cms.controller as baseController
from app.model import baseMode
from app.view_models.cms import CMS_Log_ViewModel
from app.repository.my_stock.userRepository import UserRepository

controllerName = baseController.Get_Ctrl_Name(__file__)
areaName = baseController.Get_Area_Name(__file__)

@app.route('/' + areaName + '/' + controllerName + '/in', methods=['GET', 'POST'])
def in_At_log_At_cms():
    if request.method == 'GET':
        if 'CMS_User_Info' in session:
            session.pop('CMS_User_Info')
        return render_template(areaName + '/log/in.html')
    
    returnValues = baseMode.BaseAPIJsonModel()
    DataItem = CMS_Log_ViewModel.CMS_Log_In_QueryModel()
    DataItem.Account = request.values.get('Account', type=str)
    DataItem.Password = request.values.get('Password', type=str)
    ModelRequestCheckResult, ModelRequestCheck_FieldErrMsg = DataItem.ModelRequestCheck()
    # print(DataItem)
    # print(ModelRequestCheckResult)
    # print(ModelRequestCheck_FieldErrMsg)
    if ModelRequestCheckResult == False:
        returnValues.result = baseMode.BaseAPISimpleJsonModel().ExecResultOption.Fail
        returnValues.msg = '請填寫正確資料'
        returnValues.fields_err_msg = ModelRequestCheck_FieldErrMsg
        return json.dumps(returnValues, default=vars)

    SqlExecResult, UserItem = UserRepository().FindById(DataItem.Account, idName='Account')
    if SqlExecResult == False or UserItem == None :
        returnValues.result = baseMode.BaseAPISimpleJsonModel().ExecResultOption.Fail
        returnValues.msg = '登入失敗，請確認資料是否正確'
        return json.dumps(returnValues, default=vars)


    session['CMS_User_Info'] = UserItem

    # print(session['CMS_User_Info'])

    returnValues.result = baseMode.BaseAPISimpleJsonModel().ExecResultOption.Success
    returnValues.msg = ''
    return json.dumps(returnValues, default=vars)

    
@app.route('/' + areaName + '/' + controllerName + '/in', methods=['POST'])
def in_post_At_log_At_cms():
    returnValues = baseMode.BaseAPIJsonModel()
    DataItem = CMS_Log_ViewModel.CMS_Log_In_QueryModel()
    DataItem.Account = request.values.get('Account', type=str)
    DataItem.Password = request.values.get('Password', type=str)
    ModelRequestCheckResult, ModelRequestCheck_FieldErrMsg = DataItem.ModelRequestCheck()
    # print(DataItem)
    # print(ModelRequestCheckResult)
    # print(ModelRequestCheck_FieldErrMsg)
    if ModelRequestCheckResult == False:
        returnValues.result = baseMode.BaseAPISimpleJsonModel().ExecResultOption.Fail
        returnValues.msg = '請填寫正確資料'
        returnValues.fields_err_msg = ModelRequestCheck_FieldErrMsg
        return json.dumps(returnValues, default=vars)

    SqlExecResult, UserItem = UserRepository().FindById(DataItem.Account, idName='Account')
    if SqlExecResult == False or UserItem == None :
        returnValues.result = baseMode.BaseAPISimpleJsonModel().ExecResultOption.Fail
        returnValues.msg = '登入失敗，請確認資料是否正確'
        return json.dumps(returnValues, default=vars)


    session['CMS_User_Info'] = UserItem

    # print(session['CMS_User_Info'])

    returnValues.result = baseMode.BaseAPISimpleJsonModel().ExecResultOption.Success
    returnValues.msg = ''
    return json.dumps(returnValues, default=vars)