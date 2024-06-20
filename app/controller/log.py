import os
import logging
from flask import request,render_template,flash,abort,url_for,redirect,session,Flask,g
from app import app

controllerName = os.path.splitext(os.path.basename(__file__))[0]

@app.route('/' + controllerName + '/in', methods=['GET'])
def in_At_log():
    logging.error('login')
    return render_template('log/in.html')
    
@app.route('/' + controllerName + '/in', methods=['POST'])
def in_post_At_log():
    if 'logged_in' not in session:
        session['logged_in'] = ''
    session['logged_in'] = 'Y'
    # session.permanent = True #設定Session於重開瀏覽器後是否還有效
    logging.error('login-Y')
    return redirect(url_for('index_At_home'))