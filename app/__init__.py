import os
import logging as logging
from flask import Flask

# template_dir = os.path.dirname(os.path.dirname(os.path.abspath(os.path.dirname(__file__))))
template_dir = os.path.abspath(os.path.dirname(__file__))
template_dir = os.path.join(template_dir, 'views')
# template_dir = os.path.join(template_dir, 'templates')

app = Flask(__name__, template_folder=template_dir)
app.secret_key = "__code_by_kart.chang@gmail.com__" # for session use

# app.logger.error('template_dir11:' + template_dir)
# logging.error('template_dir22:' + template_dir)


from app.controller import home
from app.controller import log