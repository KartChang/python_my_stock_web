import os
import logging
from logging.handlers import TimedRotatingFileHandler

# import pandas as pd
# link = 'https://openapi.twse.com.tw/v1/exchangeReport/STOCK_DAY_ALL'
# data = pd.read_json(link)
# # data.columns = ['Code','Name','TradeVolume','TradeValue','OpeningPrice','HighestPrice','LowestPrice','ClosingPrice','Change','Transaction']
# print(data)
# exit()



from app import app


LogsFolder = os.path.abspath(os.path.dirname(__file__))
LogsFolder = os.path.join(LogsFolder, 'logs')
logging.error('LogsFolder: ' + LogsFolder)
if not os.path.exists(LogsFolder):
    os.makedirs(LogsFolder)

rotation_logging_handler = TimedRotatingFileHandler(LogsFolder + '//localhost', when='midnight')
rotation_logging_handler.setLevel(logging.DEBUG)
rotation_logging_handler.setFormatter(logging.Formatter(u'%(asctime)s\t%(levelname)s\t%(filename)s:%(lineno)d\t%(message)s'))
rotation_logging_handler.suffix = '%Y-%m-%d'

logger = logging.getLogger()
# logger.setLevel(logging.INFO)
logger.addHandler(rotation_logging_handler)

if __name__ == "__main__":
    app.run(debug=True, port=7780)