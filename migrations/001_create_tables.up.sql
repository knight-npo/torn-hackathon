CREATE TABLE countries (
    id varchar(3),
    name varchar(50),
    PRIMARY KEY (id)
);

INSERT INTO countries VALUES
    ('arg', 'Argentina'),
    ('can', 'Canada'),
    ('cay', 'Cayman Islands'),
    ('chi', 'China'),
    ('haw', 'Hawaii'),
    ('jap', 'Japan'),
    ('mex', 'Mexico'),
    ('sou', 'South Africa'),
    ('swi', 'Switzerland'),
    ('uae', 'UAE'),
    ('uni', 'United Kingdom');

CREATE TABLE svc_log (
    svc varchar(20),
    last_updated timestamp,
    PRIMARY KEY (svc)
);

CREATE TABLE country_stocks (
    country varchar(3),
    updated timestamp,
    PRIMARY KEY (country)
);

CREATE TABLE item_stocks (
    country varchar(3),
    item_id int,
    item_name varchar(50),
    quantity int,
    cost bigint,
    PRIMARY KEY (country, item_id)
);

CREATE TABLE points_market (
    quantity int,
    cost int,
    total_cost bigint
);
