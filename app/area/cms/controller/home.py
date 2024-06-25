import os
import logging
import inspect
import json
import pandas 
import numpy 
from flask import request,render_template,flash,abort,url_for,redirect,session,Flask,g,jsonify
from app import app
import app.area.cms.controller as baseController
from app.model import baseMode
from app.utility_tools import function
from app.view_models.cms.CMS_Home_ViewModel import CMS_Home_ViewModel
# from app.repository.my_stock.stockRepository import StockRepository
# from flask_login import login_required

controllerName = baseController.Get_Ctrl_Name(__file__)
areaName = baseController.Get_Area_Name(__file__)

@app.route('/' + areaName + '/' + controllerName, methods=['POST','GET'])
@app.route('/' + areaName, methods=['POST','GET'])
@function.cms_login_required('CMS_User_Info', 'in_At_log_At_cms')
# @login_required
def index_At_home_At_cms():
    # print(inspect.stack()[0][3])
    model = CMS_Home_ViewModel()
    model.CtrlName = controllerName
    model.ActName = inspect.stack()[0][3]
    
    return render_template('cms/home/index.html', model=model)











