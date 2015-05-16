<?php
return array(
    'catsalad\\V1\\Rest\\Attack_type\\Controller' => array(
        'collection' => array(
            'GET' => array(
                'description' => 'Get attack type collection.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/attack_type"
       },
       "first": {
           "href": "/attack_type?page={page}"
       },
       "prev": {
           "href": "/attack_type?page={page}"
       },
       "next": {
           "href": "/attack_type?page={page}"
       },
       "last": {
           "href": "/attack_type?page={page}"
       }
   }
   "_embedded": {
       "attack_type": [
           {
               "_links": {
                   "self": {
                       "href": "/attack_type[/:attack_type_id]"
                   }
               }
              "id": "The identifier of the attack type.",
              "name": "The name of the attack type.",
              "created_at": "The creation time of the attack type.",
              "updated_at": "The updated time of the attack type."
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'description' => 'Attack type collection operations.',
        ),
        'entity' => array(
            'GET' => array(
                'description' => 'Get the attack type entity.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/attack_type[/:attack_type_id]"
       }
   }
   "id": "The identifier of the attack type.",
   "name": "The name of the attack type.",
   "created_at": "The creation time of the attack type.",
   "updated_at": "The updated time of the attack type."
}',
            ),
            'PATCH' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'PUT' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'DELETE' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'description' => 'Attack type entity operations.',
        ),
        'description' => 'Attack Type API',
    ),
    'catsalad\\V1\\Rest\\Boss_attacker\\Controller' => array(
        'collection' => array(
            'GET' => array(
                'description' => 'Get all the attackers related to the boss.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/boss_attacker"
       },
       "first": {
           "href": "/boss_attacker?page={page}"
       },
       "prev": {
           "href": "/boss_attacker?page={page}"
       },
       "next": {
           "href": "/boss_attacker?page={page}"
       },
       "last": {
           "href": "/boss_attacker?page={page}"
       }
   }
   "_embedded": {
       "boss_attacker": [
           {
               "_links": {
                   "self": {
                       "href": "/boss_attacker[/:boss_attacker_id]"
                   }
               }
              "id": "The identifier of the boss attacker entity.",
              "boss_id": "The identifier of the boss that is attacked.",
              "cat_id": "The identifier of the cat that is attacking the boss.",
              "created_at": "The time of the entity is created.",
              "updated_at": "The time of the entity is updated."
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'Tell the server that the cat is attacking the specific boss.',
                'request' => '{
   "boss_id": "The identifier of the boss that is attacked.",
   "cat_id": "The identifier of the cat that is attacking the boss."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/boss_attacker[/:boss_attacker_id]"
       }
   }
   "id": "The identifier of the boss attacker entity.",
   "boss_id": "The identifier of the boss that is attacked.",
   "cat_id": "The identifier of the cat that is attacking the boss.",
   "created_at": "The time of the entity is created.",
   "updated_at": "The time of the entity is updated."
}',
            ),
            'description' => 'The boss attacker collection.',
        ),
        'entity' => array(
            'GET' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'PATCH' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'PUT' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'DELETE' => array(
                'description' => 'Leaving the attacking state.',
            ),
            'description' => 'The boss attacker entity.',
        ),
        'description' => 'Use this API when,
1. If the cat is attacking the active boss, the toy device should send a POST http request. The request contains the information about the attacked boss id and attacker cat id.
2. If the cat is leaving to attack the boss, the toy device should send a DELETE http request. After the request is processed, server will send the notification to Phone App to notify the Cat is leaving to attack the boss.',
    ),
    'catsalad\\V1\\Rest\\Active_boss\\Controller' => array(
        'collection' => array(
            'GET' => array(
                'description' => 'All the boss that can be fought.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/active_boss"
       },
       "first": {
           "href": "/active_boss?page={page}"
       },
       "prev": {
           "href": "/active_boss?page={page}"
       },
       "next": {
           "href": "/active_boss?page={page}"
       },
       "last": {
           "href": "/active_boss?page={page}"
       }
   }
   "_embedded": {
       "active_boss": [
           {
               "_links": {
                   "self": {
                       "href": "/active_boss[/:active_boss_id]"
                   }
               }
              "id": "The identifier of the entity of the active boss.",
              "boss": "The active boss collection",
              "order": "The order of the active boss."
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'description' => 'Active boss collection.',
        ),
        'entity' => array(
            'GET' => array(
                'description' => 'Get the specific active boss.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/active_boss[/:active_boss_id]"
       }
   }
   "id": "The identifier of the entity of the active boss.",
   "boss": "The active boss collection",
   "order": "The order of the active boss."
}',
            ),
            'PATCH' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'PUT' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'DELETE' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'description' => 'Active boss entity.',
        ),
        'description' => 'Use this API to query the boss which can be fought.',
    ),
    'catsalad\\V1\\Rest\\Battle_partner\\Controller' => array(
        'collection' => array(
            'GET' => array(
                'description' => 'Retrieve the partners of the battle.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/battle/:battle_id/partner"
       },
       "first": {
           "href": "/battle/:battle_id/partner?page={page}"
       },
       "prev": {
           "href": "/battle/:battle_id/partner?page={page}"
       },
       "next": {
           "href": "/battle/:battle_id/partner?page={page}"
       },
       "last": {
           "href": "/battle/:battle_id/partner?page={page}"
       }
   }
   "_embedded": {
       "partner": [
           {
               "_links": {
                   "self": {
                       "href": "/battle/:battle_id/partner[/:partner_id]"
                   }
               }
              "id": "Object id of the cat.",
              "name": "The name of the cat.",
              "image_url": "The profile image url for the cat.",
              "lvl": "The level of the cat.",
              "exp": "The experience value of the cat.",
              "created_at": "The created time for the cat.",
              "updated_at": "The latest updated time for the cat.",
              "gender": "The gender of the cat. It\'s \'boy\' or \'girl\'.",
              "location": "The location of the cat position.",
              "equipped_weapon_id": "The equipped weapon id.",
              "location": {
                  "latitude": "The latitude GPS location of the cat.",
                  "longitude": "The longitude GPS location of the cat."
              }
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'Join the battle.',
                'request' => '{
   "cat_id": "Object id of the cat."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/battle/:battle_id/partner[/:partner_id]"
       }
   }
   "id": "Object id of the cat.",
   "name": "The name of the cat.",
   "image_url": "The profile image url for the cat.",
   "lvl": "The level of the cat.",
   "exp": "The experience value of the cat.",
   "created_at": "The created time for the cat.",
   "updated_at": "The latest updated time for the cat.",
   "gender": "The gender of the cat. It\'s \'boy\' or \'girl\'.",
   "location": "The location of the cat position.",
   "equipped_weapon_id": "The equipped weapon id.",
   "location": {
       "latitude": "The latitude GPS location of the cat.",
       "longitude": "The longitude GPS location of the cat."
   }
}',
            ),
            'description' => 'Partners of the battle.',
        ),
        'entity' => array(
            'GET' => array(
                'description' => 'Retrieve the partner entity.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/battle/:battle_id/partner[/:partner_id]"
       }
   }
   "id": "Object id of the cat.",
   "name": "The name of the cat.",
   "image_url": "The profile image url for the cat.",
   "lvl": "The level of the cat.",
   "exp": "The experience value of the cat.",
   "created_at": "The created time for the cat.",
   "updated_at": "The latest updated time for the cat.",
   "gender": "The gender of the cat. It\'s \'boy\' or \'girl\'.",
   "location": "The location of the cat position.",
   "equipped_weapon_id": "The equipped weapon id.",
   "location": {
       "latitude": "The latitude GPS location of the cat.",
       "longitude": "The longitude GPS location of the cat."
   }
}',
            ),
            'PATCH' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'PUT' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'DELETE' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'description' => 'The partner entity.',
        ),
        'description' => 'The API is about the partners of the battle. Currently, the Partner is defined as the Cat.',
    ),
    'catsalad\\V1\\Rest\\Battle\\Controller' => array(
        'collection' => array(
            'GET' => array(
                'description' => 'Retrieve the battle collection.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/battle"
       },
       "first": {
           "href": "/battle?page={page}"
       },
       "prev": {
           "href": "/battle?page={page}"
       },
       "next": {
           "href": "/battle?page={page}"
       },
       "last": {
           "href": "/battle?page={page}"
       }
   }
   "_embedded": {
       "battle": [
           {
               "_links": {
                   "self": {
                       "href": "/battle[/:battle_id]"
                   }
               }
              "id": "The identifier of the battle.",
              "name": "The battle name",
              "thumb_image_url": "The battle thumbnail image url.",
              "fullsize_image_url": "The full-size image url.",
              "activated_time": "The active time of the battle. User can enter into this battle after this time.",
              "created_at": "The created time of the battle.",
              "updated_at": "The updated time of the battle."
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'Create a new battle.',
                'request' => '{
   "name": "The battle name",
   "thumb_image_url": "The battle thumbnail image url.",
   "fullsize_image_url": "The full-size image url.",
   "activated_time": "The active time of the battle. User can enter into this battle after this time.",
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/battle[/:battle_id]"
       }
   }
   "id": "The identifier of the battle.",
   "name": "The battle name",
   "thumb_image_url": "The battle thumbnail image url.",
   "fullsize_image_url": "The full-size image url.",
   "activated_time": "The active time of the battle. User can enter into this battle after this time.",
   "created_at": "The created time of the battle.",
   "updated_at": "The updated time of the battle."
}',
            ),
            'description' => 'The battle collection.',
        ),
        'entity' => array(
            'GET' => array(
                'description' => 'Retrieve the battle entity.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/battle[/:battle_id]"
       }
   }
   "id": "The identifier of the battle.",
   "name": "The battle name",
   "thumb_image_url": "The battle thumbnail image url.",
   "fullsize_image_url": "The full-size image url.",
   "activated_time": "The active time of the battle. User can enter into this battle after this time.",
   "created_at": "The created time of the battle.",
   "updated_at": "The updated time of the battle."
}',
            ),
            'PATCH' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'PUT' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'DELETE' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'description' => 'The battle entity.',
        ),
        'description' => 'The API is about the Battle. A battle contains the information about the image, activated time, boss, and partners.',
    ),
    'catsalad\\V1\\Rest\\Boss\\Controller' => array(
        'collection' => array(
            'GET' => array(
                'description' => 'Retrieve the boss collection.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/boss"
       },
       "first": {
           "href": "/boss?page={page}"
       },
       "prev": {
           "href": "/boss?page={page}"
       },
       "next": {
           "href": "/boss?page={page}"
       },
       "last": {
           "href": "/boss?page={page}"
       }
   }
   "_embedded": {
       "boss": [
           {
               "_links": {
                   "self": {
                       "href": "/boss[/:boss_id]"
                   }
               }
              "id": "The identifier of the boss resource.",
              "name": "The name of the boss.",
              "hp": "The HP of the boss.",
              "description": "The description of the boss.",
              "attack_pattern": "The attack pattern of the boss.",
              "created_at": "The create time of the boss.",
              "updated_at": "The update time of the boss."
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'Create a new boss in the system.',
                'request' => '{
   "name": "The name of the boss.",
   "hp": "The HP of the boss.",
   "description": "The description of the boss.",
   "attack_pattern": "The attack pattern of the boss."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/boss[/:boss_id]"
       }
   }
   "id": "The identifier of the boss resource.",
   "name": "The name of the boss.",
   "hp": "The HP of the boss.",
   "description": "The description of the boss.",
   "attack_pattern": "The attack pattern of the boss.",
   "created_at": "The create time of the boss.",
   "updated_at": "The update time of the boss."
}',
            ),
            'description' => 'The boss collection',
        ),
        'entity' => array(
            'GET' => array(
                'description' => 'Retrieve the boss entity.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/boss[/:boss_id]"
       }
   }
   "id": "The identifier of the boss resource.",
   "name": "The name of the boss.",
   "hp": "The HP of the boss.",
   "description": "The description of the boss.",
   "attack_pattern": "The attack pattern of the boss.",
   "created_at": "The create time of the boss.",
   "updated_at": "The update time of the boss."
}',
            ),
            'PATCH' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'PUT' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'DELETE' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'description' => 'The boss entity.',
        ),
        'description' => 'The API is about the boss. We need to access this API to retrieve the boss that are defined in the system.',
    ),
    'catsalad\\V1\\Rest\\Cat\\Controller' => array(
        'collection' => array(
            'GET' => array(
                'description' => 'Get cat collection',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/cat"
       },
       "first": {
           "href": "/cat?page={page}"
       },
       "prev": {
           "href": "/cat?page={page}"
       },
       "next": {
           "href": "/cat?page={page}"
       },
       "last": {
           "href": "/cat?page={page}"
       }
   }
   "_embedded": {
       "cat": [
           {
               "_links": {
                   "self": {
                       "href": "/cat[/:cat_id]"
                   }
               }
              "id": "Object id of the cat.",
              "name": "The name of the cat.",
              "image_url": "The profile image url for the cat.",
              "lvl": "The level of the cat.",
              "exp": "The experience value of the cat.",
              "score": "The score value of the cat.",
              "gender": "The gender of the cat. It\'s \'boy\' or \'girl\'.",
              "location": "The location of the cat position.",
              "created_at": "The created time for the cat.",
              "updated_at": "The latest updated time for the cat.",
              "_embedded": {
                  "equipped_weapon": "The equipped weapon",
              }
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'N/A',
                'response' => null,
            ),
            'description' => 'Cat collection related operations',
        ),
        'entity' => array(
            'GET' => array(
                'description' => 'Get a cat resource',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/cat[/:cat_id]"
       }
   }
   "id": "Object id of the cat.",
   "name": "The name of the cat.",
   "image_url": "The profile image url for the cat.",
   "lvl": "The level of the cat.",
   "exp": "The experience value of the cat.",
   "gender": "The gender of the cat. It\'s \'boy\' or \'girl\'.",
   "location": "The location of the cat position.",
   "created_at": "The created time for the cat.",
   "updated_at": "The latest updated time for the cat.",
   "_embedded": {
       "equipped_weapon": "The equipped weapon",
   }
}',
            ),
            'PATCH' => array(
                'description' => null,
                'request' => null,
                'response' => null,
            ),
            'PUT' => array(
                'description' => 'Modify a cat resource',
                'request' => '{
   "name": "The name of the cat.",
   "image_url": "The profile image url for the cat.",
   "gender": "The gender of the cat. It\'s \'boy\' or \'girl\'.",
   "equipped_weapon_id": "The equipped weapon id.",
   "location": {
       "latitude": "The latitude GPS location of the cat.",
       "longitude": "The longitude GPS location of the cat."
   }
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/cat[/:cat_id]"
       }
   }
   "id": "Object id of the cat.",
   "name": "The name of the cat.",
   "image_url": "The profile image url for the cat.",
   "lvl": "The level of the cat.",
   "exp": "The experience value of the cat.",
   "score": "The score value of the cat.",
   "gender": "The gender of the cat. It\'s \'boy\' or \'girl\'.",
   "location": "The location of the cat position.",
   "created_at": "The created time for the cat.",
   "updated_at": "The latest updated time for the cat."
   "_embedded": {
       "equipped_weapon": "The equipped weapon",
   }
}',
            ),
            'DELETE' => array(
                'description' => 'Delete a cat resource',
                'request' => null,
                'response' => null,
            ),
        ),
        'description' => 'Cat API',
    ),
    'catsalad\\V1\\Rest\\Toy_device\\Controller' => array(
        'collection' => array(
            'GET' => array(
                'description' => 'Get toy device collection',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/toy_device"
       },
       "first": {
           "href": "/toy_device?page={page}"
       },
       "prev": {
           "href": "/toy_device?page={page}"
       },
       "next": {
           "href": "/toy_device?page={page}"
       },
       "last": {
           "href": "/toy_device?page={page}"
       }
   }
   "_embedded": {
       "toy_device": [
           {
               "_links": {
                   "self": {
                       "href": "/toy_device[/:toy_device_id]"
                   }
               }
              "id": "The object id of the toy device.",
              "is_use_system_recommended_time": "A boolean value to indicate the user uses the system recommended time or user\'s scheduling time.",
              "is_enable_sound": "A boolean value to indicate the system sound is enabled or not.",
              "system_recommended_time": "The play time given by system for enabling the toy.",
              "user_scheduled_time": "The play time given by user for enabling the toy.",
              "created_at": "The created time of the toy device.",
              "updated_at": "The updated time of the toy device.",
              "location": "The location of the toy device."
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'N/A',
                'request' => null,
                'response' => null,
            ),
            'description' => 'Toy device collection operations',
        ),
        'entity' => array(
            'GET' => array(
                'description' => 'Get the toy device entity.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/toy_device[/:toy_device_id]"
       }
   }
   "id": "The object id of the toy device.",
   "is_use_system_recommended_time": "A boolean value to indicate the user uses the system recommended time or user\'s scheduling time.",
   "is_enable_sound": "A boolean value to indicate the system sound is enabled or not.",
   "system_recommended_time": "The play time given by system for enabling the toy.",
   "user_scheduled_time": "The play time given by user for enabling the toy.",
   "created_at": "The created time of the toy device.",
   "updated_at": "The updated time of the toy device.",
   "location": "The location of the toy device."
}',
            ),
            'PATCH' => array(
                'description' => 'N/A',
                'request' => null,
                'response' => null,
            ),
            'PUT' => array(
                'description' => 'Modify the toy device entity',
                'request' => '{
   "user_scheduled_time": "The play time given by user for enabling the toy.",
   "is_use_system_recommended_time": "A boolean value to indicate the user uses the system recommended time or user\'s scheduling time.",
   "is_enable_sound": "A boolean value to indicate the system sound is enabled or not.",
   "location": {
       "latitude": "The latitude value in GPS location.",
       "longitude": "The longitude value in GPS location."
   }
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/toy_device[/:toy_device_id]"
       }
   }
   "id": "The object id of the toy device.",
   "system_recommended_time": "The play time given by system for enabling the toy.",
   "user_scheduled_time": "The play time given by user for enabling the toy.",
   "created_at": "The created time of the toy device.",
   "updated_at": "The updated time of the toy device.",
   "location": "The location of the toy device."
}',
            ),
            'DELETE' => array(
                'description' => 'Delete the toy device entity.',
                'request' => null,
                'response' => null,
            ),
            'description' => 'Toy device entity operations.',
        ),
        'description' => 'Toy Device API',
    ),
    'catsalad\\V1\\Rest\\User\\Controller' => array(
        'description' => 'User API',
        'collection' => array(
            'GET' => array(
                'description' => 'Get all the signed up users.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/user"
       },
       "first": {
           "href": "/user?page={page}"
       },
       "prev": {
           "href": "/user?page={page}"
       },
       "next": {
           "href": "/user?page={page}"
       },
       "last": {
           "href": "/user?page={page}"
       }
   }
   "_embedded": {
       "user": [
           {
               "_links": {
                   "self": {
                       "href": "/user[/:user_id]"
                   }
               }
              "id": "The identifier of the user.",
              "name": "user name",
              "created_at": "the timestamp for the entity is created",
              "updated_at": "the timestamp for the entity is updated",
              _embedded: {
                  "cat": "The cats bind to this user",
                  "toy_device": "The bind toy device for the user.",
              }
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'Register a new user.',
                'request' => '{
   "name": "user name",
   "cat_name": "The cat name.",
   "device_token": "The token for the device.",
   "toy_device_id": "The toy device id.",
   "social_user_id": "The social user id that is got from the social network service.",
   "social_provider_name": "The social provider name. It can be \'facebook\' or \'google\'.",
   "social_access_token": "The user short-lived access token from social login.",
   "location": {
       "latitude": "The latitude GPS location of the toy device.",
       "longitude": "The longitude GPS location of the toy device."
   }
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/user[/:user_id]"
       }
   }
   "id": "The identifier of the user.",
   "name": "cat name",
   "created_at": "the timestamp for the entity is created",
   "updated_at": "the timestamp for the entity is updated",
   "device_token": "The token for the device.",
   "access_token": "The user access token that is used to access all the APIs.",
   "social_provider": "The social provider that user uses to login/signup.",
   "toy_device": "The bind toy device for the user.",
    _embedded: {
        "toy_device": "The bind toy device for the user.",
        "cat": "The cats bind to this user"
    }
}',
            ),
            'description' => 'All the signed users in the system.',
        ),
        'entity' => array(
            'GET' => array(
                'description' => 'Get a user resource.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/user[/:user_id]"
       }
   }
   "id": "The identifier of the user.",
   "name": "user name",
   "created_at": "the timestamp for the entity is created",
   "updated_at": "the timestamp for the entity is updated",
   "device_token": "The token for the device.",
   "access_token": "The user access token that is used to access all the APIs.",
   "social_provider": "The social provider that user uses to login/signup.",
   _embedded: {
       "toy_device": "The toy device entity bind to this user",
       "cat": "The cats bind to this user"
   }
}',
            ),
            'PATCH' => array(
                'description' => 'N/A',
                'request' => null,
                'response' => null,
            ),
            'PUT' => array(
                'description' => 'Modify the content of the resource',
                'request' => '{
   "name": "user name",
   "device_token": "The token for the device.",
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/user[/:user_id]"
       }
   }
   "id": "The identifier of the user.",
   "name": "user name",
   "created_at": "the timestamp for the entity is created",
   "updated_at": "the timestamp for the entity is updated",
   "device_token": "The token for the device.",
   "access_token": "The user access token that is used to access all the APIs.",
   "social_provider": "The social provider that user uses to login/signup.",
  _embedded: {
    "toy_device": "The toy device entity bind to this user",
    "cat": "The cats bind to this user"
  }
}',
            ),
            'DELETE' => array(
                'description' => 'Delete the resource',
                'request' => null,
                'response' => null,
            ),
            'description' => 'Entity related operations.',
        ),
    ),
    'catsalad\\V1\\Rest\\Cat_activity\\Controller' => array(
        'collection' => array(
            'GET' => array(
                'description' => 'Get cat activity collection.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/cat/:cat_id/activity"
       },
       "first": {
           "href": "/cat/:cat_id/activity?page={page}"
       },
       "prev": {
           "href": "/cat/:cat_id/activity?page={page}"
       },
       "next": {
           "href": "/cat/:cat_id/activity?page={page}"
       },
       "last": {
           "href": "/cat/:cat_id/activity?page={page}"
       }
   }
   "_embedded": {
       "activity": [
           {
               "_links": {
                   "self": {
                       "href": "/cat/:cat_id/activity[/:activity_id]"
                   }
               }
              "id": "The object id of the cat activity.",
              "battle_id": "The identifier of battle. Every activity is occurred in the battle.",
              "hit_type": "The type of hit. There are two types, such as",
              "time": "The created time of the cat activity.",
              "exp": "The experience for the cat activity.",
              "score": "The score for the cat activity.",
              "created_at": "The created time of the activity."
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'Create a cat activity on the Server when the cat had hit the boss.',
                'request' => '{
   "id": "The object id of the cat activity.",
   "battle_id": "The identifier of battle. Every activity is occurred in the battle.",
   "hit_type": "The type of hit. There are two types, such as hit or combo",
   "time": "The created time of the cat activity."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/cat/:cat_id/activity[/:activity_id]"
       }
   }
   "id": "The object id of the cat activity.",
   "battle_id": "The identifier of battle. Every activity is occurred in the battle.",
   "hit_type": "The type of hit. There are two types, such as hit or combo",
   "time": "The created time of the cat activity.",
   "exp": "The experience for the cat activity.",
   "score": "The score for the cat activity.",
   "created_at": "The created time of the activity."
}',
            ),
            'description' => 'Cat activity collection operations.',
        ),
        'entity' => array(
            'GET' => array(
                'description' => 'Get cat activity entity.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/cat/:cat_id/activity[/:activity_id]"
       }
   }
   "id": "The object id of the cat activity.",
   "battle_id": "The identifier of battle. Every activity is occurred in the battle.",
   "hit_type": "The type of hit. There are two types, such as hit or combo",
   "time": "The created time of the cat activity.",
   "exp": "The experience for the cat activity.",
   "score": "The score for the cat activity.",
   "created_at": "The created time of the activity."
}',
            ),
            'PATCH' => array(
                'description' => 'N/A',
                'request' => null,
                'response' => null,
            ),
            'PUT' => array(
                'description' => 'N/A',
                'request' => null,
                'response' => null,
            ),
            'DELETE' => array(
                'description' => 'N/A',
                'request' => null,
                'response' => null,
            ),
            'description' => 'Cat activity entity operations.',
        ),
        'description' => 'This API is about the cat\'s activities. We could retrieve the cat\'s activities via this API. I suppose client developer uses this API to retrieve the cat\'s activities with sorting by date or by date and hour.',
    ),
    'catsalad\\V1\\Rest\\Attack_pattern\\Controller' => array(
        'collection' => array(
            'GET' => array(
                'description' => 'Get attack pattern collection.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/attack_pattern"
       },
       "first": {
           "href": "/attack_pattern?page={page}"
       },
       "prev": {
           "href": "/attack_pattern?page={page}"
       },
       "next": {
           "href": "/attack_pattern?page={page}"
       },
       "last": {
           "href": "/attack_pattern?page={page}"
       }
   }
   "_embedded": {
       "attack_pattern": [
           {
               "_links": {
                   "self": {
                       "href": "/attack_pattern[/:attack_pattern_id]"
                   }
               }
              "id": "The identifier of the attack-pattern.",
              "name": "The name of the attack-pattern.",
              "attack_type": "The attack types of the attack-pattern.",
              "created_at": "Creation time of the attack pattern.",
              "updated_at": "Updating time of the attack pattern."
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'N/A',
                'request' => null,
                'response' => null,
            ),
            'description' => 'Attack pattern collection operations.',
        ),
        'entity' => array(
            'GET' => array(
                'description' => 'Get attack pattern entity.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/attack_pattern[/:attack_pattern_id]"
       }
   }
   "id": "The identifier of the attack-pattern.",
   "name": "The name of the attack-pattern.",
   "attack_type": "The attack types of the attack-pattern.",
   "created_at": "Creation time of the attack pattern.",
   "updated_at": "Updating time of the attack pattern."
}',
            ),
            'PATCH' => array(
                'description' => 'N/A',
                'request' => null,
                'response' => null,
            ),
            'PUT' => array(
                'description' => 'N/A',
                'request' => null,
                'response' => null,
            ),
            'DELETE' => array(
                'description' => 'N/A',
                'request' => null,
                'response' => null,
            ),
            'description' => 'Attack pattern entity operations.',
        ),
        'description' => 'Attack pattern API. Every attack pattern that includes one attack type or more.',
    ),
    'catsalad\\V1\\Rest\\Battle_boss\\Controller' => array(
        'collection' => array(
            'GET' => array(
                'description' => 'Retrieve the boss of the battle.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/battle/:battle_id/boss"
       },
       "first": {
           "href": "/battle/:battle_id/boss?page={page}"
       },
       "prev": {
           "href": "/battle/:battle_id/boss?page={page}"
       },
       "next": {
           "href": "/battle/:battle_id/boss?page={page}"
       },
       "last": {
           "href": "/battle/:battle_id/boss?page={page}"
       }
   }
   "_embedded": {
       "boss": [
           {
               "_links": {
                   "self": {
                       "href": "/battle/:battle_id/boss[/:boss_id]"
                   }
               }
              "id": "The identifier of the boss resource.",
              "name": "The name of the boss.",
              "hp": "The HP of the boss.",
              "description": "The description of the boss.",
              "attack_pattern": "The attack pattern of the boss.",
              "created_at": "The create time of the boss.",
              "updated_at": "The update time of the boss."
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'description' => 'The boss collection.',
        ),
        'entity' => array(
            'GET' => array(
                'description' => 'Retrieve the boss entity.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/battle/:battle_id/boss[/:boss_id]"
       }
   }
   "id": "The identifier of the boss resource.",
   "name": "The name of the boss.",
   "hp": "The HP of the boss.",
   "description": "The description of the boss.",
   "attack_pattern": "The attack pattern of the boss.",
   "created_at": "The create time of the boss.",
   "updated_at": "The update time of the boss."
}',
            ),
            'PATCH' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'PUT' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'DELETE' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'description' => 'The boss entity.',
        ),
        'description' => 'The API is about the boss of the battle. A battle includes the boss. We could obtain all the boss via this API.',
    ),
    'catsalad\\V1\\Rest\\Battle_participant\\Controller' => array(
        'collection' => array(
            'GET' => array(
                'description' => 'Retrieve the participant collection.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/battle/:battle_id/participant"
       },
       "first": {
           "href": "/battle/:battle_id/participant?page={page}"
       },
       "prev": {
           "href": "/battle/:battle_id/participant?page={page}"
       },
       "next": {
           "href": "/battle/:battle_id/participant?page={page}"
       },
       "last": {
           "href": "/battle/:battle_id/participant?page={page}"
       }
   }
   "_embedded": {
       "participant": [
           {
               "_links": {
                   "self": {
                       "href": "/battle/:battle_id/participant[/:participant_id]"
                   }
               }
              "id": "Object id of the cat.",
              "name": "The name of the cat.",
              "image_url": "The profile image url for the cat.",
              "lvl": "The level of the cat.",
              "gender": "The gender of the cat. It\'s \'boy\' or \'girl\'.",
              "exp": "The experience value of the cat.",
              "score": "The score of the participant.",
              "created_at": "The created time for the cat.",
              "updated_at": "The latest updated time for the cat.",
              "location": {
                  "latitude": "The latitude GPS location of the cat.",
                  "longitude": "The longitude GPS location of the cat.",
              },
              "_embedded": {
                    "equipped_weapon": "The equipped weapon.",
              }
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'Join the battle',
                'request' => '{
   "cat_id": "Object id of the cat.",
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/battle/:battle_id/participant[/:participant_id]"
       }
   }
   "id": "Object id of the cat.",
   "name": "The name of the cat.",
   "image_url": "The profile image url for the cat.",
   "gender": "The gender of the cat. It\'s \'boy\' or \'girl\'.",
   "lvl": "The level of the cat.",
   "exp": "The experience value of the cat.",
   "score": "The score of the participant."
   "created_at": "The created time for the cat.",
   "updated_at": "The latest updated time for the cat.",
   "location": {
       "latitude": "The latitude GPS location of the cat.",
       "longitude": "The longitude GPS location of the cat.",
   },
   "_embedded": {
       "equipped_weapon": "The equipped weapon.",
   }
}',
            ),
            'description' => 'Participant collection operations.',
        ),
        'entity' => array(
            'GET' => array(
                'description' => 'Retrieve the participant entity.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/battle/:battle_id/participant[/:participant_id]"
       }
   }
   "id": "Object id of the cat.",
   "name": "The name of the cat.",
   "image_url": "The profile image url for the cat.",
   "gender": "The gender of the cat. It\'s \'boy\' or \'girl\'.",
   "lvl": "The level of the cat.",
   "exp": "The experience value of the cat.",
   "score": "The score of the participant."
   "created_at": "The created time for the cat.",
   "updated_at": "The latest updated time for the cat.",
   "location": {
       "latitude": "The latitude GPS location of the cat.",
       "longitude": "The longitude GPS location of the cat.",
   },
   "_embedded": {
       "equipped_weapon": "The equipped weapon.",
   }
}',
            ),
            'PATCH' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'PUT' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'DELETE' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'description' => 'Participant entity operations.',
        ),
        'description' => 'This API shows the participants in the specified battle. We could retrieve all the participants (cats) via this API. This API also provides the sorting type (score or location) for developer to easy to retrieve the specified participant set.',
    ),
    'catsalad\\V1\\Rest\\Battle_activity\\Controller' => array(
        'collection' => array(
            'GET' => array(
                'description' => 'Retrieve the participant activity.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/battle/:battle_id/participant/:participant_id/activity"
       },
       "first": {
           "href": "/battle/:battle_id/participant/:participant_id/activity?page={page}"
       },
       "prev": {
           "href": "/battle/:battle_id/participant/:participant_id/activity?page={page}"
       },
       "next": {
           "href": "/battle/:battle_id/participant/:participant_id/activity?page={page}"
       },
       "last": {
           "href": "/battle/:battle_id/participant/:participant_id/activity?page={page}"
       }
   }
   "_embedded": {
       "activity": [
           {
               "_links": {
                   "self": {
                       "href": "/battle/:battle_id/participant/:participant_id/activity[/:activity_id]"
                   }
               }
              "id": "The object id of the cat activity.",
              "hit_type": "The type of hit. There are two types, such as",
              "time": "The created time of the cat activity.",
              "exp": "The experience for the cat activity.",
              "score": "The score for the cat activity.",
              "created_at": "The created time of the activity."
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'Create a new activity.',
                'request' => '{
   "hit_type": "The type of hit. There are two types, such as",
   "time": "The created time of the cat activity."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/battle/:battle_id/participant/:participant_id/activity[/:activity_id]"
       }
   }
   "id": "The object id of the cat activity.",
   "hit_type": "The type of hit. There are two types, such as",
   "time": "The created time of the cat activity.",
   "exp": "The experience for the cat activity.",
   "score": "The score for the cat activity.",
   "created_at": "The created time of the activity."
}',
            ),
            'description' => 'The participant activity collection operations.',
        ),
        'entity' => array(
            'GET' => array(
                'description' => 'Retrieve the participant entity.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/battle/:battle_id/participant/:participant_id/activity[/:activity_id]"
       }
   }
   "id": "The object id of the cat activity.",
   "hit_type": "The type of hit. There are two types, such as",
   "time": "The created time of the cat activity.",
   "exp": "The experience for the cat activity.",
   "score": "The score for the cat activity.",
   "created_at": "The created time of the activity."
}',
            ),
            'PATCH' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'PUT' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'DELETE' => array(
                'description' => 'n/a',
                'request' => null,
                'response' => null,
            ),
            'description' => 'The participant entity operations.',
        ),
        'description' => 'This API concats onto the battle route to make developer that could easy to handle the cat\'s activities. We suppose developers use this API in the battle page.',
    ),
    'catsalad\\V1\\Rest\\Toy_control\\Controller' => array(
        'collection' => array(
            'GET' => array(
                'description' => 'Retrieve the un-done controlled statement.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/battle/:battle_id/toy_device/:toy_device_id/control"
       },
       "first": {
           "href": "/battle/:battle_id/toy_device/:toy_device_id/control?page={page}"
       },
       "prev": {
           "href": "/battle/:battle_id/toy_device/:toy_device_id/control?page={page}"
       },
       "next": {
           "href": "/battle/:battle_id/toy_device/:toy_device_id/control?page={page}"
       },
       "last": {
           "href": "/battle/:battle_id/toy_device/:toy_device_id/control?page={page}"
       }
   }
   "_embedded": {
       "control": [
           {
               "_links": {
                   "self": {
                       "href": "/battle/:battle_id/toy_device/:toy_device_id/control[/:control_id]"
                   }
               }
              "id": "The identifier of the control information.",
              "battle_id": "The identifier of the battle.",
              "toy_device_id": "The identifier of the toy device.",
              "type": "The type of the control.",
              "is_done": "The done flag of the control statement.",
              "created_at": "The created time of this entity.",
              "updated_at": "The updated time of this entity."
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'Create a new controlled statement for the particular battle and toy device.',
                'request' => '{
   "type": "The type of the control."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/battle/:battle_id/toy_device/:toy_device_id/control[/:control_id]"
       }
   }
   "id": "The identifier of the control information.",
   "battle_id": "The identifier of the battle.",
   "toy_device_id": "The identifier of the toy device.",
   "type": "The type of the control.",
   "is_done": "The done flag of the control statement.",
   "created_at": "The created time of this entity.",
   "updated_at": "The updated time of this entity."
}',
            ),
            'description' => 'The collection of the controlled statements.',
        ),
        'entity' => array(
            'GET' => array(
                'description' => 'Retrieve the specified controlled statement.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/battle/:battle_id/toy_device/:toy_device_id/control[/:control_id]"
       }
   }
   "id": "The identifier of the control information.",
   "battle_id": "The identifier of the battle.",
   "toy_device_id": "The identifier of the toy device.",
   "type": "The type of the control.",
   "is_done": "The done flag of the control statement.",
   "created_at": "The created time of this entity.",
   "updated_at": "The updated time of this entity."
}',
            ),
            'description' => 'The entity of the controlled statement.',
            'PUT' => array(
                'description' => 'Modify the status of the controlled statement.',
                'request' => '{
   "is_done": "The done flag of the control statement."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/battle/:battle_id/toy_device/:toy_device_id/control[/:control_id]"
       }
   }
   "id": "The identifier of the control information.",
   "battle_id": "The identifier of the battle.",
   "toy_device_id": "The identifier of the toy device.",
   "type": "The type of the control.",
   "is_done": "The done flag of the control statement.",
   "created_at": "The created time of this entity.",
   "updated_at": "The updated time of this entity."
}',
            ),
        ),
        'description' => 'We could use this API to control the toy device. For the Phone-App client side, it need to send the control statement to Server. For the toy device side, it needs to retrieve the control statement via this API. If any statement is processed, the device needs to modify the is_done column for the control statement.',
    ),
    'catsalad\\V1\\Rest\\Weapon\\Controller' => array(
        'collection' => array(
            'GET' => array(
                'description' => 'Get weapon collection',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/weapon"
       },
       "first": {
           "href": "/weapon?page={page}"
       },
       "prev": {
           "href": "/weapon?page={page}"
       },
       "next": {
           "href": "/weapon?page={page}"
       },
       "last": {
           "href": "/weapon?page={page}"
       }
   }
   "_embedded": {
       "weapon": [
           {
               "_links": {
                   "self": {
                       "href": "/weapon[/:weapon_id]"
                   }
               }
              "id": "The object id of the weapon.",
              "attack_bonus": "The attack bonus of the weapon.",
              "image_url": "The image url of the weapon.",
              "available_level": "This indicates the weapon is available when over the specified level.",
              "created_at": "The create time of the weapon resource.",
              "updated_at": "The update time of the weapon resource."
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'N/A',
                'request' => null,
                'response' => null,
            ),
            'description' => 'Weapon collection operations',
        ),
        'entity' => array(
            'GET' => array(
                'description' => 'Get weapon resource',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/weapon[/:weapon_id]"
       }
   }
   "id": "The object id of the weapon.",
   "attack_bonus": "The attack bonus of the weapon.",
   "image_url": "The image url of the weapon.",
   "available_level": "This indicates the weapon is available when over the specified level.",
   "created_at": "The create time of the weapon resource.",
   "updated_at": "The update time of the weapon resource."
}',
            ),
            'PATCH' => array(
                'description' => 'N/A',
                'request' => null,
                'response' => null,
            ),
            'PUT' => array(
                'description' => 'N/A',
                'request' => null,
                'response' => null,
            ),
            'DELETE' => array(
                'description' => 'N/A',
                'request' => null,
                'response' => null,
            ),
            'description' => 'Weapon resource operations',
        ),
        'description' => 'Developer could retrieve the available weapons via this API.',
    ),
    'catsalad\\V1\\Rest\\Cat_weapon\\Controller' => array(
        'collection' => array(
            'GET' => array(
                'description' => 'Get the equipped weapon.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/cat/:cat_id/equipped_weapon"
       },
       "first": {
           "href": "/cat/:cat_id/equipped_weapon?page={page}"
       },
       "prev": {
           "href": "/cat/:cat_id/equipped_weapon?page={page}"
       },
       "next": {
           "href": "/cat/:cat_id/equipped_weapon?page={page}"
       },
       "last": {
           "href": "/cat/:cat_id/equipped_weapon?page={page}"
       }
   }
   "_embedded": {
       "equipped_weapon": [
           {
               "_links": {
                   "self": {
                       "href": "/cat/:cat_id/equipped_weapon[/:equipped_weapon_id]"
                   }
               }
              "id": "The object id of the weapon.",
              "attack_bonus": "The attack bonus of the weapon.",
              "image_url": "The image url of the weapon.",
              "created_at": "The create time of the weapon resource.",
              "updated_at": "The update time of the weapon resource.",
              "available_level": "This indicates the weapon is available when over the specified level."
           }
       ]
   }
}',
            ),
            'POST' => array(
                'description' => 'Replace the equipped weapon by another weapon.',
                'request' => '{
   "id": "The object id of the weapon."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/cat/:cat_id/equipped_weapon[/:equipped_weapon_id]"
       }
   }
   "id": "The object id of the weapon.",
   "attack_bonus": "The attack bonus of the weapon.",
   "image_url": "The image url of the weapon.",
   "created_at": "The create time of the weapon resource.",
   "updated_at": "The update time of the weapon resource.",
   "available_level": "This indicates the weapon is available when over the specified level."
}',
            ),
            'description' => 'The equipped weapon.',
        ),
        'entity' => array(
            'GET' => array(
                'description' => null,
                'request' => null,
                'response' => null,
            ),
        ),
        'description' => 'The API is used to retrieve the cat\'s equipped weapon or to replace the equipped weapon by another available weapon.',
    ),
    'catsalad\\V1\\Rest\\Toydevice_user\\Controller' => array(
        'collection' => array(
            'GET' => array(
                'description' => 'Retrieve the user entity that binds to toy device.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/toy_device/:toy_device_id/user"
       },
       "first": {
           "href": "/toy_device/:toy_device_id/user?page={page}"
       },
       "prev": {
           "href": "/toy_device/:toy_device_id/user?page={page}"
       },
       "next": {
           "href": "/toy_device/:toy_device_id/user?page={page}"
       },
       "last": {
           "href": "/toy_device/:toy_device_id/user?page={page}"
       }
   }
   "_embedded": {
       "user": [
           {
               "_links": {
                   "self": {
                       "href": "/toy_device/:toy_device_id/user"
                   }
               }
              "id": "The identifier of the user.",
              "name": "user name",
              "cat_id": "The cat identifier.",
              "created_at": "the timestamp for the entity is created",
              "updated_at": "the timestamp for the entity is updated"
           }
       ]
   }
}',
            ),
            'description' => 'The user entity.',
        ),
        'description' => 'The API helps developers to receive the user that is bind to the given toy device.',
    ),
    'catsalad\\V1\\Rest\\LevelTable\\Controller' => array(
        'collection' => array(
            'GET' => array(
                'description' => 'Retrieve the level table collection.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/level_table"
       },
       "first": {
           "href": "/level_table?page={page}"
       },
       "prev": {
           "href": "/level_table?page={page}"
       },
       "next": {
           "href": "/level_table?page={page}"
       },
       "last": {
           "href": "/level_table?page={page}"
       }
   }
   "_embedded": {
       "level_table": [
           {
               "_links": {
                   "self": {
                       "href": "/level_table[/:level_table_id]"
                   }
               }
              "id": "The identifier of the level.",
              "level": "The level value.",
              "exp": "The experience of the level needs.",
              "next_exp": "The experience of the next level needs."
           }
       ]
   }
}',
            ),
            'description' => 'The level collections.',
        ),
        'entity' => array(
            'GET' => array(
                'description' => 'Retrieve the level entity.',
                'request' => null,
                'response' => '{
   "_links": {
       "self": {
           "href": "/level_table[/:level_table_id]"
       }
   }
   "id": "The identifier of the level.",
   "level": "The level value.",
   "exp": "The experience of the level needs.",
   "next_exp": "The experience of the next level needs."
}',
            ),
            'description' => 'The level entity.',
        ),
        'description' => 'The API provides the level table for developers to know what the level is of the cat.',
    ),
);
