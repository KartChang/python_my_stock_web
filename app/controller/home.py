import os
from flask import request,render_template,flash,abort,url_for,redirect,session,Flask,g
from app import app

controllerName = os.path.splitext(os.path.basename(__file__))[0]

@app.route('/' + controllerName, methods=['POST','GET'])
@app.route('/', methods=['POST','GET'])
def index_At_home():
    if not session.get('logged_in'):
        # abort(401)
        return redirect(url_for('in_At_log'))
    return "Hello, MVC框架!" + os.path.splitext(os.path.basename(__file__))[0]