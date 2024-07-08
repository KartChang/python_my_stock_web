import os
import logging as logging
import json
from datetime import timedelta
from flask import Flask,request,g
from flask_babel import Babel
from werkzeug.exceptions import HTTPException
from app.utility_tools import function

# template_folder = os.path.dirname(os.path.dirname(os.path.abspath(os.path.dirname(__file__))))
template_folder = os.path.abspath(os.path.dirname(__file__))
template_folder = os.path.join(template_folder, 'views')
# template_folder = os.path.join(template_folder, 'templates')

static_folder = os.path.dirname(os.path.abspath(os.path.dirname(__file__)))
static_folder = os.path.join(static_folder, 'assets')

app = Flask(__name__, template_folder=template_folder, static_folder=static_folder)
app.secret_key = "__code_by_kart.chang@gmail.com__" # for session use
app.permanent_session_lifetime = timedelta(minutes=20)

locales_folder = os.path.abspath(os.path.dirname(__file__))
locales_folder = os.path.join(locales_folder, 'locales')
app.config['BABEL_DEFAULT_LOCALE'] = 'zh'
app.config['BABEL_DEFAULT_TIMEZONE'] = 'UTC'
app.config['BABEL_TRANSLATION_DIRECTORIES'] = locales_folder
# babel = Babel(app)

# app.logger.error('template_dir11:' + template_dir)
# logging.error('template_dir22:' + template_dir)

app.jinja_env.globals.update(StringIsNullOrWhiteSpace=function.StringIsNullOrWhiteSpace)

from app.controller import home
from app.controller import log

from app.area.cms.controller import log as cms_log
from app.area.cms.controller import home as cms_home
from app.area.cms.controller import user as cms_user

# @babel.localeselector
def get_locale():
    # g.LOCALE = 'zh_TW'
    # g.LOCALE = 'zh'
    # print(g.LOCALE)
    # return getattr(g, 'LOCALE', 'zh')
    return request.accept_languages.best_match(['zh', 'en'])
    
babel = Babel(app, locale_selector=get_locale)
# babel.init_app(app, locale_selector=get_locale)

from flask_babel import gettext
from flask_babel import force_locale
# with force_locale('zh'):
#     app.config['BABEL_DEFAULT_LOCALE'] = 'zh'
#     print(gettext('StatusOption_Enable'))

@app.route('/', defaults={'path': ''})
@app.route('/<path:path>')
def catch_all(path):
    # returns a 200 (not a 404) with the following contents:
    return 'your custom error content\n'

@app.errorhandler(404)
def page_not_found(error):
    return '404 error'
    
@app.errorhandler(HTTPException)
def handle_exception(e):
    """Return JSON instead of HTML for HTTP errors."""
    # start with the correct headers and status code from the error
    response = e.get_response()
    # replace the body with JSON
    response.data = json.dumps({
        "code": e.code,
        "name": e.name,
        "description": e.description,
    })
    response.content_type = "application/json"
    return response