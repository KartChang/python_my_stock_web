import os
import logging
from flask import request,render_template,flash,abort,url_for,redirect,session,Flask,g
from app import app
import app.area.cms.controller as baseController

controllerName = baseController.Get_Ctrl_Name(__file__)
areaName = baseController.Get_Area_Name(__file__)

@app.route('/' + areaName + '/' + controllerName + '/in', methods=['GET'])
def in_At_log_At_cms():
    session.pop('')
    return render_template(areaName + '/log/in.html')
    
@app.route('/' + areaName + '/' + controllerName + '/in', methods=['POST'])
def in_post_At_log_At_cms():
    if 'logged_in' not in session:
        session['logged_in'] = ''
    session['logged_in'] = 'Y'
    # session.permanent = True #設定Session於重開瀏覽器後是否還有效
    logging.error('login-Y')
    return redirect(url_for('index_At_home'))