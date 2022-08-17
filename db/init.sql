
CREATE TABLE plants (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  plant_name TEXT NOT NULL UNIQUE,
  genus TEXT NOT NULL UNIQUE,
  plantid TEXT NOT NULL UNIQUE,
  file_ext TEXT
);

CREATE TABLE tags (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  tag_name TEXT NOT NULL UNIQUE
);

CREATE TABLE users (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  name TEXT NOT NULL,
  username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL
);

INSERT INTO
  users (id, name, username, password)
VALUES
  (
    1,
    'Rhea Kak',
    'rhea',
    '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'
  );

INSERT INTO
  users (id, name, username, password)
VALUES
  (
    2,
    'Kate Steenkamer',
    'kate',
    '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'
  );

CREATE TABLE sessions (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  user_id INTEGER NOT NULL,
  session TEXT NOT NULL UNIQUE,
  last_login TEXT NOT NULL,
  FOREIGN KEY(user_id) REFERENCES users(id)
);


CREATE TABLE play_types (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  plant_id INTEGER NOT NULL UNIQUE,
  supports_exploratory_constructive_play INTEGER NOT NULL,
  supports_exploratory_sensory_play INTEGER NOT NULL,
  supports_physical_play INTEGER NOT NULL,
  supports_imaginative_play INTEGER NOT NULL,
  supports_restorative_play INTEGER NOT NULL,
  supports_expressive_play INTEGER NOT NULL,
  supports_play_with_rules INTEGER NOT NULL,
  supports_bio_play INTEGER NOT NULL,
  FOREIGN KEY (plant_id) REFERENCES plants(id)
);



CREATE TABLE cares (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  care_name TEXT NOT NULL UNIQUE
);

CREATE TABLE plant_tags (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  plant_id INTEGER NOT NULL,
  tag_id INTEGER NOT NULL,
  FOREIGN KEY (plant_id) REFERENCES plants(id),
  FOREIGN KEY (tag_id) REFERENCES tags(id)
);

CREATE TABLE plant_cares (
  id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  plant_id INTEGER NOT NULL,
  care_id INTEGER NOT NULL,
  FOREIGN KEY (plant_id) REFERENCES plants(id),
  FOREIGN KEY (care_id) REFERENCES cares(id)
);


INSERT INTO
  plants (
    id,
    plant_name,
    genus,
    plantid,
    file_ext
  )
VALUES
  (
    1,
    'Bee balm',
    'Monarda dydima',
    'FL_29',
    'jpg'
  );

INSERT INTO
  plants (
    id,
    plant_name,
    genus,
    plantid,
    file_ext
  )
VALUES
  (
    2,
    'Blue phlox',
    'Phlox divaricata',
    'GR_25',
    'jpg'
  );

INSERT INTO
  plants (
    id,
    plant_name,
    genus,
    plantid,
    file_ext
  )
VALUES
  (
    3,
    'Bottlebrush grass',
    'Elymus hystrix',
    'GA_06',
    'jpg'
  );

INSERT INTO
  plants (
    id,
    plant_name,
    genus,
    plantid,
    file_ext
  )
VALUES
  (
    4,
    'Alpine Strawberry',
    'Fragaria vesca',
    'GR_04',
    'jpg'
  );

INSERT INTO
  plants (
    id,
    plant_name,
    genus,
    plantid,
    file_ext
  )
VALUES
  (
    5,
    'Primrose',
    'Primula vulgaris',
    'FL_23',
    'jpg'
  );

INSERT INTO
  plants (
    id,
    plant_name,
    genus,
    plantid,
    file_ext
  )
VALUES
  (
    6,
    'Weeping Eastern White Pine',
    'Pinus strobus "Pendula"',
    'TR_32',
    'jpg'
  );

INSERT INTO
  plants (
    id,
    plant_name,
    genus,
    plantid,
    file_ext
  )
VALUES
  (
    7,
    'Wild Yam',
    'Dioscorea villosa',
    'VI-06',
    'jpg'
  );

INSERT INTO
  plants (
    id,
    plant_name,
    genus,
    plantid,
    file_ext
  )
VALUES
  (
    8,
    'American Wisteria',
    'Wisteria frutescens',
    'VI_16',
    'jpg'
  );

INSERT INTO
  plants (
    id,
    plant_name,
    genus,
    plantid,
    file_ext
  )
VALUES
  (
    9,
    'Sweet Fern',
    'Comptonia peregrina',
    'SH_05',
    'jpg'
  );

INSERT INTO
  plants (
    id,
    plant_name,
    genus,
    plantid,
    file_ext
  )
VALUES
  (
    10,
    'Spicebush',
    'Lindera benzoin',
    'SH_06',
    'jpg'
  );

INSERT INTO
  plants (
    id,
    plant_name,
    genus,
    plantid,
    file_ext
  )
VALUES
  (
    11,
    'Big Bluestem',
    'Andropogun gerardii',
    'GA_04',
    'jpg'
  );

INSERT INTO
  plants (
    id,
    plant_name,
    genus,
    plantid,
    file_ext
  )
VALUES
  (
    12,
    'Yellow Indian Grass',
    'Sorghastrum nutans',
    'GA_10',
    'jpg'
  );


INSERT INTO
  tags (
    id,
    tag_name
  )
VALUES
  (
    1,
    'Shrub'
  );

INSERT INTO
  tags (
    id,
    tag_name
  )
VALUES
  (
    2,
    'Grass'
  );

INSERT INTO
  tags (
    id,
    tag_name
  )
VALUES
  (
    3,
    'Vine'
  );

INSERT INTO
  tags (
    id,
    tag_name
  )
VALUES
  (
    4,
    'Tree'
  );

INSERT INTO
  tags (
    id,
    tag_name
  )
VALUES
  (
    5,
    'Flower'
  );

INSERT INTO
  tags (
    id,
    tag_name
  )
VALUES
  (
    6,
    'Groundcovers'
  );


INSERT INTO
  play_types (
    id,
    plant_id,
    supports_exploratory_constructive_play,
    supports_exploratory_sensory_play,
    supports_physical_play,
    supports_imaginative_play,
    supports_restorative_play,
    supports_expressive_play,
    supports_play_with_rules,
    supports_bio_play
  )
VALUES
  (
    1,
    1,
    0,
    1,
    1,
    1,
    0,
    0,
    0,
    1
  );

INSERT INTO
  play_types (
    id,
    plant_id,
    supports_exploratory_constructive_play,
    supports_exploratory_sensory_play,
    supports_physical_play,
    supports_imaginative_play,
    supports_restorative_play,
    supports_expressive_play,
    supports_play_with_rules,
    supports_bio_play
  )
VALUES
  (
    2,
    2,
    0,
    1,
    1,
    1,
    1,
    0,
    0,
    1
  );

INSERT INTO
  play_types (
    id,
    plant_id,
    supports_exploratory_constructive_play,
    supports_exploratory_sensory_play,
    supports_physical_play,
    supports_imaginative_play,
    supports_restorative_play,
    supports_expressive_play,
    supports_play_with_rules,
    supports_bio_play
  )
VALUES
  (
    3,
    3,
    1,
    1,
    1,
    0,
    1,
    0,
    0,
    0
  );

INSERT INTO
  play_types (
    id,
    plant_id,
    supports_exploratory_constructive_play,
    supports_exploratory_sensory_play,
    supports_physical_play,
    supports_imaginative_play,
    supports_restorative_play,
    supports_expressive_play,
    supports_play_with_rules,
    supports_bio_play
  )
VALUES
  (
    4,
    4,
    0,
    1,
    1,
    0,
    0,
    0,
    0,
    1
  );

INSERT INTO
  play_types (
    id,
    plant_id,
    supports_exploratory_constructive_play,
    supports_exploratory_sensory_play,
    supports_physical_play,
    supports_imaginative_play,
    supports_restorative_play,
    supports_expressive_play,
    supports_play_with_rules,
    supports_bio_play
  )
VALUES
  (
    5,
    5,
    0,
    1,
    1,
    0,
    0,
    0,
    0,
    1
  );

INSERT INTO
  play_types (
    id,
    plant_id,
    supports_exploratory_constructive_play,
    supports_exploratory_sensory_play,
    supports_physical_play,
    supports_imaginative_play,
    supports_restorative_play,
    supports_expressive_play,
    supports_play_with_rules,
    supports_bio_play
  )
VALUES
  (
    6,
    6,
    1,
    1,
    1,
    1,
    1,
    0,
    0,
    1
  );

INSERT INTO
  play_types (
    id,
    plant_id,
    supports_exploratory_constructive_play,
    supports_exploratory_sensory_play,
    supports_physical_play,
    supports_imaginative_play,
    supports_restorative_play,
    supports_expressive_play,
    supports_play_with_rules,
    supports_bio_play
  )
VALUES
  (
    7,
    7,
    0,
    1,
    1,
    0,
    0,
    0,
    0,
    0
  );

INSERT INTO
  play_types (
    id,
    plant_id,
    supports_exploratory_constructive_play,
    supports_exploratory_sensory_play,
    supports_physical_play,
    supports_imaginative_play,
    supports_restorative_play,
    supports_expressive_play,
    supports_play_with_rules,
    supports_bio_play
  )
VALUES
  (
    8,
    8,
    0,
    1,
    1,
    1,
    1,
    0,
    0,
    1
  );

INSERT INTO
  play_types (
    id,
    plant_id,
    supports_exploratory_constructive_play,
    supports_exploratory_sensory_play,
    supports_physical_play,
    supports_imaginative_play,
    supports_restorative_play,
    supports_expressive_play,
    supports_play_with_rules,
    supports_bio_play
  )
VALUES
  (
    9,
    9,
    0,
    1,
    1,
    1,
    0,
    0,
    1,
    1
  );

INSERT INTO
  play_types (
    id,
    plant_id,
    supports_exploratory_constructive_play,
    supports_exploratory_sensory_play,
    supports_physical_play,
    supports_imaginative_play,
    supports_restorative_play,
    supports_expressive_play,
    supports_play_with_rules,
    supports_bio_play
  )
VALUES
  (
    10,
    10,
    0,
    1,
    1,
    1,
    1,
    0,
    0,
    1
  );

INSERT INTO
  play_types (
    id,
    plant_id,
    supports_exploratory_constructive_play,
    supports_exploratory_sensory_play,
    supports_physical_play,
    supports_imaginative_play,
    supports_restorative_play,
    supports_expressive_play,
    supports_play_with_rules,
    supports_bio_play
  )
VALUES
  (
    11,
    11,
    1,
    1,
    0,
    1,
    1,
    0,
    1,
    1
  );

INSERT INTO
  play_types (
    id,
    plant_id,
    supports_exploratory_constructive_play,
    supports_exploratory_sensory_play,
    supports_physical_play,
    supports_imaginative_play,
    supports_restorative_play,
    supports_expressive_play,
    supports_play_with_rules,
    supports_bio_play
  )
VALUES
  (
    12,
    12,
    1,
    1,
    0,
    0,
    1,
    0,
    0,
    1
  );


INSERT INTO
  cares (
    id,
    care_name
  )
VALUES
  (
    1,
    'Perennial'
  );

INSERT INTO
  cares (
    id,
    care_name
  )
VALUES
  (
    2,
    'Annual'
  );

INSERT INTO
  cares (
    id,
    care_name
  )
VALUES
  (
    3,
    'Full Sun'
  );

INSERT INTO
  cares (
    id,
    care_name
  )
VALUES
  (
    4,
    'Partial Shade'
  );

INSERT INTO
  cares (
    id,
    care_name
  )
VALUES
  (
    5,
    'Full Shade'
  );

INSERT INTO
  cares (
    id,
    care_name
  )
VALUES
  (
    6,
    'Hardiness Zone: 4-9'
  );

INSERT INTO
  cares (
    id,
    care_name
  )
VALUES
  (
    7,
    'Hardiness Zone: 3-8'
  );

INSERT INTO
  cares (
    id,
    care_name
  )
VALUES
  (
    8,
    'Hardiness Zone: 5-9'
  );

INSERT INTO
  cares (
    id,
    care_name
  )
VALUES
  (
    9,
    'Hardiness Zone: 4-8'
  );

INSERT INTO
  cares (
    id,
    care_name
  )
VALUES
  (
    10,
    'Hardiness Zone: 2-5'
  );

INSERT INTO
  cares (
    id,
    care_name
  )
VALUES
  (
    11,
    'Hardiness Zone: 3-9'
  );


INSERT INTO
  plant_tags (
    id,
    plant_id,
    tag_id
  )
VALUES
  (
    1,
    1,
    5
  );

INSERT INTO
  plant_tags (
    id,
    plant_id,
    tag_id
  )
VALUES
  (
    2,
    2,
    6
  );

INSERT INTO
  plant_tags (
    id,
    plant_id,
    tag_id
  )
VALUES
  (
    3,
    3,
    2
  );

INSERT INTO
  plant_tags (
    id,
    plant_id,
    tag_id
  )
VALUES
  (
    4,
    4,
    6
  );

INSERT INTO
  plant_tags (
    id,
    plant_id,
    tag_id
  )
VALUES
  (
    5,
    5,
    5
  );

INSERT INTO
  plant_tags (
    id,
    plant_id,
    tag_id
  )
VALUES
  (
    6,
    6,
    4
  );

INSERT INTO
  plant_tags (
    id,
    plant_id,
    tag_id
  )
VALUES
  (
    7,
    7,
    3
  );

INSERT INTO
  plant_tags (
    id,
    plant_id,
    tag_id
  )
VALUES
  (
    8,
    8,
    3
  );

INSERT INTO
  plant_tags (
    id,
    plant_id,
    tag_id
  )
VALUES
  (
    9,
    9,
    1
  );

INSERT INTO
  plant_tags (
    id,
    plant_id,
    tag_id
  )
VALUES
  (
    10,
    10,
    1
  );

INSERT INTO
  plant_tags (
    id,
    plant_id,
    tag_id
  )
VALUES
  (
    11,
    11,
    2
  );

INSERT INTO
  plant_tags (
    id,
    plant_id,
    tag_id
  )
VALUES
  (
    12,
    12,
    2
  );


INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    1,
    1,
    1
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    2,
    1,
    3
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    3,
    1,
    4
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    4,
    1,
    6
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    5,
    2,
    1
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    6,
    2,
    4
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    7,
    2,
    5
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    8,
    2,
    7
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    9,
    3,
    1
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    10,
    3,
    4
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    11,
    3,
    5
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    12,
    3,
    8
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    13,
    4,
    1
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    14,
    4,
    3
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    15,
    4,
    4
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    16,
    4,
    8
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    17,
    5,
    1
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    18,
    5,
    4
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    19,
    5,
    5
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    20,
    5,
    9
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    21,
    6,
    1
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    22,
    6,
    3
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    23,
    6,
    4
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    24,
    6,
    7
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    25,
    7,
    1
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    26,
    7,
    3
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    27,
    7,
    4
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    28,
    7,
    9
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    29,
    8,
    1
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    30,
    8,
    3
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    31,
    8,
    8
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    32,
    9,
    1
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    33,
    9,
    4
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    34,
    9,
    10
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    35,
    10,
    1
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    36,
    10,
    3
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    37,
    10,
    4
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    38,
    10,
    6
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    39,
    11,
    1
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    40,
    11,
    3
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    41,
    11,
    11
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    42,
    12,
    1
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    43,
    12,
    3
  );

INSERT INTO
  plant_cares (
    id,
    plant_id,
    care_id
  )
VALUES
  (
    44,
    12,
    6
  );
