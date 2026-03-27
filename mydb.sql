create database mydb;
create table users(
id int AUTO_INCREMENT PRIMARY KEY,
username varchar(50)not null,
email varchar(50)not null UNIQUE,
passwordd varchar(255)NOT null,
role ENUM('admin','user') DEFAULT 'user',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  
);

create table categories(
id int AUTO_INCREMENT PRIMARY KEY,
name varchar(255)

);
CREATE table prompts(
    id INT AUTO_INCREMENT PRIMARY KEY,
    title varchar (255),
    content varchar (255),
    user_id int not null,
    categories_id int not null,
    CONSTRAINT fk_user_id  FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_categories_id  FOREIGN KEY (categories_id) REFERENCES categories(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);