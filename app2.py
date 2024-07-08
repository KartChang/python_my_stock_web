# Import necessary libraries
# Install datasets, tokenizers library if you've not done so yet (!pip install datasets, tokenizers).
import os
import math
import torch
import torch.nn as nn
from torch.utils.data import Dataset, DataLoader
from pathlib import Path
from datasets import load_dataset
from tqdm import tqdm
# Assign device value as "cuda" to train on GPU if GPU is available. Otherwise it will fall back to default as "cpu".
device = torch.device("cuda" if torch.cuda.is_available() else "cpu")  
# Loading train, validation, test dataset from huggingface path below.
raw_train_dataset = load_dataset("Helsinki-NLP/opus-100", "en-ms", split='train')
raw_validation_dataset = load_dataset("Helsinki-NLP/opus-100", "en-ms", split='validation')
raw_test_dataset = load_dataset("Helsinki-NLP/opus-100", "en-ms", split='test')
# Directory to store dataset files.
os.mkdir("./dataset-en")
os.mkdir("./dataset-my")
# Directory to save model during model training after each EPOCHS (in step 10).
os.mkdir("./malaygpt")
# Director to store source and target tokenizer.
os.mkdir("./tokenizer_en")
os.mkdir("./tokenizer_my")
dataset_en = []     
dataset_my = []
file_count = 1      
# In order to train the tokenizer (in step 2), we'll separate the training dataset into english and malay. 
# Create multiple small file of size 50k data each and store into dataset-en and dataset-my directory.
for data in tqdm(raw_train_dataset["translation"]):
    dataset_en.append(data["en"].replace('\n', " "))
    dataset_my.append(data["ms"].replace('\n', " "))
    if len(dataset_en) == 50000:
        with open(f'./dataset-en/file{file_count}.txt', 'w', encoding='utf-8') as fp:
            fp.write('\n'.join(dataset_en))
            dataset_en = []
        with open(f'./dataset-my/file{file_count}.txt', 'w', encoding='utf-8') as fp:
            fp.write('\n'.join(dataset_my))
            dataset_my = []
        file_count += 1