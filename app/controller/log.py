import os
from flask import request,render_template,flash,abort,url_for,redirect,session,Flask,g
from app import app

controllerName = os.path.splitext(os.path.basename(__file__))[0]

@app.route('/' + controllerName + '/in', methods=['GET'])
def in_At_log():
    return render_template('log/in.html')