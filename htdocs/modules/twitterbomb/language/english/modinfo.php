<?php

	define('_MI_TWEETBOMB_ANONYMOUS','Anonymous');
	
	// Select Box Definitions
	define('_MI_TWEETBOMB_NONE','None at All');
	
	//Select Box Base Definitions
	define('_MI_TWEETBOMB_BASE_TITLE_FOR','For Phrase');
	define('_MI_TWEETBOMB_BASE_TITLE_WHEN','When Phrase');
	define('_MI_TWEETBOMB_BASE_TITLE_CLAUSE','Clause Phrase');
	define('_MI_TWEETBOMB_BASE_TITLE_THEN','Then Phrase');
	define('_MI_TWEETBOMB_BASE_TITLE_OVER','Over Phrase');
	define('_MI_TWEETBOMB_BASE_TITLE_UNDER','Under Phrase');
	define('_MI_TWEETBOMB_BASE_TITLE_THEIR','Their Phrase');
	define('_MI_TWEETBOMB_BASE_TITLE_THERE','There Phrase');
	
	// XOOPS_VERSION.PHP - Version 1.01
	define('_MI_TWEETBOMB_NAME','Twitter Bomb');
	define('_MI_TWEETBOMB_DESCRIPTION','Twitter Bomb is a module for XOOPS which allows keyword/keyphrase combination campaigns!');
	define('_MI_TWEETBOMB_DIRNAME','twitterbomb');
	
	// Submenus Definitions
	define('_MI_TWEETBOMBS_MENU_USERNAME','Add Twitter Username');
	
	//Preferences Definitions
	define('_MI_TWEETBOMB_AGGREGATE','Aggregate with a # Words Meeting length?');
	define('_MI_TWEETBOMB_AGGREGATE_DESC','This will place a hash symbol infront of words seperated by a space.');
	define('_MI_TWEETBOMB_WORDLENGTH','Aggregated Word Length');
	define('_MI_TWEETBOMB_WORDLENGTH_DESC','This is the minimal number of characters for aggreagated words.');
	define('_MI_TWEETBOMB_ITEMS','RSS Items');
	define('_MI_TWEETBOMB_ITEMS_DESC','Number of items to return on RSS Feeds');
	define('_MI_TWEETBOMB_HTACCESS','HTAccess SEO');
	define('_MI_TWEETBOMB_HTACCESS_DESC','You need to alter your .htaccess for this.');
	define('_MI_TWEETBOMB_BASEURL','Base of URL for SEO');
	define('_MI_TWEETBOMB_BASEURL_DESC','Base path of SEO');
	define('_MI_TWEETBOMB_ENDOFURL','End of URL for HTML');
	define('_MI_TWEETBOMB_ENDOFURL_DESC','End of URL for standard output.');
	define('_MI_TWEETBOMB_ENDOFURLRSS','End of URL for RSS');
	define('_MI_TWEETBOMB_ENDOFURLRSS_DESC','End of URL for RSS Output.');
	
	// Version 1.05
	//Preferences Definitions
	define('_MI_TWEETBOMB_PREF_ANONYMOUS','Anonymous Guest can Submit Twitter Usernames?');
	define('_MI_TWEETBOMB_PREF_ANONYMOUS_DESC','Allows anonymous guest to submit twitter usernames to campaigns and categories.');
	define('_MI_TWEETBOMB_CACHE','Number of Seconds RSS Feed is cached!');
	define('_MI_TWEETBOMB_CACHE_DESC','Total number of seconds the RSS Feed is cached for.');
	
	// Version 1.11
	//Select Box Base Definitions
	define('_MI_TWEETBOMB_MODE_TITLE_DIRECT','Direct Entry');
	define('_MI_TWEETBOMB_MODE_TITLE_FILTERED','Filtered');
	define('_MI_TWEETBOMB_MODE_TITLE_PREGMATCH','Pregmatch');
	define('_MI_TWEETBOMB_MODE_TITLE_STRIP','Strip');
	define('_MI_TWEETBOMB_MODE_TITLE_PREGMATCHSTRIP','Pregmatch + Strip');
	define('_MI_TWEETBOMB_MODE_TITLE_STRIPPREGMATCH','Strip + Pregmatch');
	define('_MI_TWEETBOMB_MODE_TITLE_FILTEREDSTRIP','Filtered + Strip');
	define('_MI_TWEETBOMB_MODE_TITLE_STRIPFILTERED','Strip + Filtered');
	define('_MI_TWEETBOMB_MODE_TITLE_FILTEREDPREGMATCH','Filtered + Pregmatch');
	define('_MI_TWEETBOMB_MODE_TITLE_PREGMATCHFILTERED','Pregmatch + Filtered');
	define('_MI_TWEETBOMB_MODE_TITLE_FILTEREDPREGMATCHSTRIP','Filtered + Pregmatch + Strip');
	define('_MI_TWEETBOMB_MODE_TITLE_FILTEREDSTRIPPREGMATCH','Filtered + Strip + Pregmatch');
	define('_MI_TWEETBOMB_MODE_TITLE_PREGMATCHFILTEREDSTRIP','Pregmatch + Filtered + Strip');
	define('_MI_TWEETBOMB_MODE_TITLE_PREGMATCHSTRIPFILTERED','Pregmatch + Strip + Filtered');
	define('_MI_TWEETBOMB_MODE_TITLE_STRIPPREGMATCHFILTERED','Strip + Pregmatch + Filtered');
	define('_MI_TWEETBOMB_MODE_TITLE_STRIPFILTEREDPREGMATCH','Strip + Filtered + Pregmatch');
	define('_MI_TWEETBOMB_MODE_TITLE_MIRC','mIRC Logs');
	define('_MI_TWEETBOMB_CAMPAIGN_TITLE_BOMB','Phrase Bomb');
	define('_MI_TWEETBOMB_CAMPAIGN_TITLE_SCHEDULER','Tweet Scheduler');
	
	//Preferences Definitions
	define('_MI_TWEETBOMB_SCHEDULER_ITEMS','Tweet Scheduler - RSS Items');
	define('_MI_TWEETBOMB_SCHEDULER_ITEMS_DESC','Number of items to return on RSS Feeds of a tweet scheduler campaign.');
	define('_MI_TWEETBOMB_SCHEDULER_CACHE','Tweet Scheduler - Number of Seconds RSS Feed is cached!');
	define('_MI_TWEETBOMB_SCHEDULER_CACHE_DESC','Total number of seconds the RSS Feed is cached for before getting the next set of scheduled tweets.');
	define('_MI_TWEETBOMB_KILL_TWEETED','Tweet Scheduler - Kill Tweeted after seconds');
	define('_MI_TWEETBOMB_KILL_TWEETED_DESC','Tweet Scheduler - Kill Tweeted and remove from the database this record after so many seconds. (0 - Disabled)');
	define('_MI_TWEETBOMB_NUMBER_TO_RANK','Tweet Scheduler - Number of Tweets to Keep in Rank');
	define('_MI_TWEETBOMB_NUMBER_TO_RANK_DESC','Tweet Scheduler - Number of Tweets to keep in scheduler rank - that are not in rank if you disable this it will not keep a rank score and all will be killed. (0 - Disabled)');
	define('_MI_TWEETBOMB_SCHEDULER_AGGREGATE','Tweet Scheduler - Aggregate with a # Words Meeting length?');
	define('_MI_TWEETBOMB_SCHEDULER_AGGREGATE_DESC','This will place a hash symbol infront of words seperated by a space.');
	define('_MI_TWEETBOMB_SCHEDULER_WORDLENGTH','Tweet Scheduler - Aggregated Word Length');
	define('_MI_TWEETBOMB_SCHEDULER_WORDLENGTH_DESC','This is the minimal number of characters for aggreagated words.');
	define('_MI_TWEETBOMB_LOG_BOMB','Log Bomb Providers');
	define('_MI_TWEETBOMB_LOG_BOMB_DESC','When Twitter Bomb bomb\'s something on the feeds, then log it!');
	define('_MI_TWEETBOMB_LOG_SCHEDULER','Log Secheduler Provider');
	define('_MI_TWEETBOMB_LOG_SCHEDULER_DESC','When Twitter Bomb sechedules\'s as tweet, then log it!');
	define('_MI_TWEETBOMB_LOGDROPS','Log Deletes Itself After');
	define('_MI_TWEETBOMB_LOGDROPS_DESC','This is how long the log stays on your site for after a record reaches this age it is deleted!');
		
	//Prefence options
	define('_MI_TWEETBOMB_LOGDROPS_24HOURS','24 Hours');
	define('_MI_TWEETBOMB_LOGDROPS_1WEEK','1 Week');
	define('_MI_TWEETBOMB_LOGDROPS_FORTNIGHT','A Fortnight');
	define('_MI_TWEETBOMB_LOGDROPS_1MONTH','1 Month');
	define('_MI_TWEETBOMB_LOGDROPS_2MONTHS','2 Months');
	define('_MI_TWEETBOMB_LOGDROPS_3MONTHS','3 Months');
	define('_MI_TWEETBOMB_LOGDROPS_4MONTHS','4 Months');
	define('_MI_TWEETBOMB_LOGDROPS_5MONTHS','5 Months');
	define('_MI_TWEETBOMB_LOGDROPS_6MONTHS','6 Months');
	define('_MI_TWEETBOMB_LOGDROPS_12MONTHS','1 Year');
	define('_MI_TWEETBOMB_LOGDROPS_24MONTHS','2 Years');
	define('_MI_TWEETBOMB_LOGDROPS_36MONTHS','3 Years');
	
	// Version 1.12
	//Preferences Definitions
	define('_MI_TWEETBOMB_SCHEDULER_USERNAMES','Tweet Scheduler - Keyword phrase for twitter username associations');
	define('_MI_TWEETBOMB_SCHEDULER_USERNAMES_DESC','Must contain a phrase that has words with the position of the twitter username replaced with <em>%username%</em>.');
	define('_MI_TWEETBOMB_SUPPORTTAGS','Support Tagging');
	define('_MI_TWEETBOMB_SUPPORTTAGS_DESC','Support Tag (2.3 or later)<br/><a href="http://sourceforge.net/projects/xoops/files/XOOPS%20Module%20Repository/XOOPS%20tag%202.30%20RC/">Download Tag Module</a>');
	
	//Version 1.13
	//Preferences Definitions
	define('_MI_TWEETBOMB_CONSUMER_KEY','Twitter Application Consumer Key');
	define('_MI_TWEETBOMB_CONSUMER_KEY_DESC','To get a <em>consumer key</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
	define('_MI_TWEETBOMB_CONSUMER_SECRET','Twitter Application Consumer Secret');
	define('_MI_TWEETBOMB_CONSUMER_SECRET_DESC','To get a <em>consumer secret</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
	define('_MI_TWEETBOMB_REQUEST_URL','Twitter Application Request URL');
	define('_MI_TWEETBOMB_REQUEST_URL_DESC','To get a <em>request url</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
	define('_MI_TWEETBOMB_AUTHORISE_URL','Twitter Application Authorise URL');
	define('_MI_TWEETBOMB_AUTHORISE_URL_DESC','To get a <em>authorise url</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
	define('_MI_TWEETBOMB_AUTHENTICATE_URL','Twitter Authentication URL');
	define('_MI_TWEETBOMB_AUTHENTICATE_URL_DESC','To get a <em>authentication url</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
	define('_MI_TWEETBOMB_ACCESS_TOKEN_URL','Twitter Application Access Token URL');
	define('_MI_TWEETBOMB_ACCESS_TOKEN_URL_DESC','To get a <em>access token url</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
	define('_MI_TWEETBOMB_CALLBACK_URL','Twitter Application Callback URL');
	define('_MI_TWEETBOMB_CALLBACK_URL_DESC','Do not change this unless you are certain you know the setting, this is also the setting for the twitter application call back URL.');
	define('_MI_TWEETBOMB_ACCESS_TOKEN','Twitter Application Root Access Token');
	define('_MI_TWEETBOMB_ACCESS_TOKEN_DESC','To get a <em>access token</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
	define('_MI_TWEETBOMB_ACCESS_TOKEN_SECRET','Twitter Application Root Access Token Secret');
	define('_MI_TWEETBOMB_ACCESS_TOKEN_SECRET_DESC','To get a <em>access token secret</em> you need to create and application on twitter (<a href="https://dev.twitter.com/apps/new">Click Here</a>)');
	define('_MI_TWEETBOMB_ROOT_TWEETER','Main Default Twitter Username (root)');
	define('_MI_TWEETBOMB_ROOT_TWEETER_DESC','Your default twitter username for the basis of following etc. (without the @)');
	define('_MI_TWEETBOMB_CRONTYPE','Cron execution type');
	define('_MI_TWEETBOMB_CRONTYPE_DESC','This is the type of cron job that is being executed. If you have set up a cronjob as per INSTALL then please select either the \'cron job\' or \'scheduler\'.');
	define('_MI_TWEETBOMB_INTERVAL_OF_CRON','Interval of Cron');
	define('_MI_TWEETBOMB_INTERVAL_OF_CRON_DESC','This is the interval between executions of the cron job. (In Seconds)');
	define('_MI_TWEETBOMB_RUNTIME_OF_CRON','Runtime of Cron');
	define('_MI_TWEETBOMB_RUNTIME_OF_CRON_DESC','This is how long the cron executes for in it runtime operations. (In Seconds)');
	define('_MI_TWEETBOMB_TWEETS_PER_SESSION','Tweets per Cron Session');
	define('_MI_TWEETBOMB_TWEETS_PER_SESSION_DESC','Number of Tweet issued per section per cron task execution.');
	define('_MI_TWEETBOMB_SALT','Salt Password for Encryption and Hashing');
	define('_MI_TWEETBOMB_SALT_DESC','Do not change on production machines!');
	define('_MI_TWEETBOMB_KEEPTRENDFOR','Cache trend results for this period.');
	define('_MI_TWEETBOMB_KEEPTRENDFOR_DESC','To improve performance trends of topics are cached for this period.');
	define('_MI_TWEETBOMB_TRENDTYPE','Trend type to retrieve');
	define('_MI_TWEETBOMB_TRENDTYPE_DESC','This is the type of trend that is retrieved from the twitter API');
	
	//Preference Options
	define('_MI_TWEETBOMB_CRONTYPE_RSS','Aggregated Via RSS Feed');
	define('_MI_TWEETBOMB_CRONTYPE_PRELOADER','Preloader');
	define('_MI_TWEETBOMB_CRONTYPE_CRONTAB','UNIX Cron Job');
	define('_MI_TWEETBOMB_CRONTYPE_SCHEDULER','Windows Scheduled Task');
	define('_MI_TWEETBOMB_CACHE_30SECONDS','Cache for 30 Seconds');
	define('_MI_TWEETBOMB_CACHE_60SECONDS','Cache for 1 Minute');
	define('_MI_TWEETBOMB_CACHE_120SECONDS','Cache for 2 Minutes');
	define('_MI_TWEETBOMB_CACHE_240SECONDS','Cache for 4 Minutes');
	define('_MI_TWEETBOMB_CACHE_480SECONDS','Cache for 8 Minutes');
	define('_MI_TWEETBOMB_CACHE_960SECONDS','Cache for 16 Minutes');
	define('_MI_TWEETBOMB_CACHE_1820SECONDS','Cache for 32 Minutes');
	define('_MI_TWEETBOMB_CACHE_1HOUR','Cache for 1 Hour');
	define('_MI_TWEETBOMB_CACHE_3HOUR','Cache for 3 Hour');
	define('_MI_TWEETBOMB_CACHE_6HOURS','Cache for 6 Hours');
	define('_MI_TWEETBOMB_CACHE_12HOURS','Cache for 12 Hours');
	define('_MI_TWEETBOMB_CACHE_24HOURS','Cache for 1 Day');
	define('_MI_TWEETBOMB_CACHE_1WEEK','Cache for 1 Week');
	define('_MI_TWEETBOMB_CACHE_FORTNIGHT','Cache for 1 Fortnight');
	define('_MI_TWEETBOMB_CACHE_1MONTH','Cache for 1 Month');
	define('_MI_TWEETBOMB_TREND_STANDARD','Standard Trend');
	define('_MI_TWEETBOMB_TREND_CURRENT','Current Trend');
	define('_MI_TWEETBOMB_TREND_DAILY','Daily Trend');
	define('_MI_TWEETBOMB_TREND_WEEKLY','Weeky Trend');
	
	//Enumerators
	define('_MI_TWEETBOMB_OAUTH_MODE_TITLE_VALID','Valid');
	define('_MI_TWEETBOMB_OAUTH_MODE_TITLE_INVALID','Invalid');
	define('_MI_TWEETBOMB_OAUTH_MODE_TITLE_EXPIRED','Expired');
	define('_MI_TWEETBOMB_OAUTH_MODE_TITLE_DISABLED','Disabled');
	define('_MI_TWEETBOMB_OAUTH_MODE_TITLE_OTHER','Other');
	
	//Select Box Definitions
	define('_MI_TWEETBOMB_BASE_TITLE_TREND','Trending Topic');
	
	//User Menus
	define('_MI_TWEETBOMBS_MENU_AUTHORISE','Authorise App at Twitter');
	
	//Version 1.14
	//Preferences Definitions
	define('_MI_TWEETBOMB_LOOK_FOR_FRIENDS','How many seconds delay between looking for new friends');
	define('_MI_TWEETBOMB_LOOK_FOR_FRIENDS_DESC','Number of seconds delay between looking for new friends.');
	define('_MI_TWEETBOMB_LOOK_FOR_MENTION','How may seconds delay between looking for new mentions');
	define('_MI_TWEETBOMB_LOOK_FOR_MENTION_DESC','Number of seconds delat between looking for new mentions.');
	define('_MI_TWEETBOMB_GATHER_PER_SESSION','How many usernames to process per cron session for new friends');
	define('_MI_TWEETBOMB_GATHER_PER_SESSION_DESC','Number of  usernames to process per cron session for new friends.');
	define('_MI_TWEETBOMB_CRON_FOLLOW','Run following script on cronjob?');
	define('_MI_TWEETBOMB_CRON_FOLLOW_DESC','Whether you want to scan and set people to follow from the username tables.');
	define('_MI_TWEETBOMB_CRON_GATHER','Run gather script on cronjob?');
	define('_MI_TWEETBOMB_CRON_GATHER_DESC','Whether you want to scan for new usernames for the username tables.');
	define('_MI_TWEETBOMB_CRON_TWEET','Run generate tweets script on cronjob?');
	define('_MI_TWEETBOMB_CRON_TWEET_DESC','Whether you want tweets to be cronned.');
	
	//Version 1.15
	define('_MI_TWEETBOMB_BITLY_USERNAME','Bit.ly Username');
	define('_MI_TWEETBOMB_BITLY_USERNAME_DESC','Bit.ly Username for shortening URLS - <a href="http://bitly.com/a/sign_up">Sign Up</a>');
	define('_MI_TWEETBOMB_BITLY_APIKEY','Bit.ly API Key');
	define('_MI_TWEETBOMB_BITLY_APIKEY_DESC','Bit.ly API Key for shortening URLS - <a href="http://bitly.com/a/your_api_key">Find Your API Key</a>');
	define('_MI_TWEETBOMB_BITLY_APIURL','Bit.ly API URL');
	define('_MI_TWEETBOMB_BITLY_APIURL_DESC','Bit.ly API URLS (Do Not Change)');
	define('_MI_TWEETBOMB_USER_AGENT','Useragent');
	define('_MI_TWEETBOMB_USER_AGENT_DESC','User agent for curl sessions');
	define('_MI_TWEETBOMB_FOLLOW_PER_SESSION','How many usernames to process per cron session for new following');
	define('_MI_TWEETBOMB_FOLLOW_PER_SESSION_DESC','Number of usernames to process per cron session for new friends and following.');
	
	//Version 1.19
	//Language Defines for 
	define("_MI_TWEETBOMB_LANGUAGE_AA","Afar");
	define("_MI_TWEETBOMB_LANGUAGE_AB","Abkhazian");
	define("_MI_TWEETBOMB_LANGUAGE_AF","Afrikaans");
	define("_MI_TWEETBOMB_LANGUAGE_AM","Amharic");
	define("_MI_TWEETBOMB_LANGUAGE_AR","Arabic");
	define("_MI_TWEETBOMB_LANGUAGE_AS","Assamese");
	define("_MI_TWEETBOMB_LANGUAGE_AY","Aymara");
	define("_MI_TWEETBOMB_LANGUAGE_AZ","Azerbaijani");
	define("_MI_TWEETBOMB_LANGUAGE_BA","Bashkir");
	define("_MI_TWEETBOMB_LANGUAGE_BE","Byelorussian");
	define("_MI_TWEETBOMB_LANGUAGE_BG","Bulgarian");
	define("_MI_TWEETBOMB_LANGUAGE_BH","Bihari");
	define("_MI_TWEETBOMB_LANGUAGE_BI","Bislama");
	define("_MI_TWEETBOMB_LANGUAGE_BN","Bengali (Bangla)");
	define("_MI_TWEETBOMB_LANGUAGE_BO","Tibetan");
	define("_MI_TWEETBOMB_LANGUAGE_BR","Breton");
	define("_MI_TWEETBOMB_LANGUAGE_CA","Catalan");
	define("_MI_TWEETBOMB_LANGUAGE_CO","Corsican");
	define("_MI_TWEETBOMB_LANGUAGE_CS","Czech");
	define("_MI_TWEETBOMB_LANGUAGE_CY","Welsh");
	define("_MI_TWEETBOMB_LANGUAGE_DA","Danish");
	define("_MI_TWEETBOMB_LANGUAGE_DE","German");
	define("_MI_TWEETBOMB_LANGUAGE_DZ","Bhutani");
	define("_MI_TWEETBOMB_LANGUAGE_EL","Greek");
	define("_MI_TWEETBOMB_LANGUAGE_EN","English");
	define("_MI_TWEETBOMB_LANGUAGE_EO","Esperanto");
	define("_MI_TWEETBOMB_LANGUAGE_ES","Spanish");
	define("_MI_TWEETBOMB_LANGUAGE_ET","Estonian");
	define("_MI_TWEETBOMB_LANGUAGE_EU","Basque");
	define("_MI_TWEETBOMB_LANGUAGE_FA","Persian");
	define("_MI_TWEETBOMB_LANGUAGE_FI","Finnish");
	define("_MI_TWEETBOMB_LANGUAGE_FJ","Fiji");
	define("_MI_TWEETBOMB_LANGUAGE_FO","Faroese");
	define("_MI_TWEETBOMB_LANGUAGE_FR","French");
	define("_MI_TWEETBOMB_LANGUAGE_FY","Frisian");
	define("_MI_TWEETBOMB_LANGUAGE_GA","Irish");
	define("_MI_TWEETBOMB_LANGUAGE_GD","Scots (Gaelic)");
	define("_MI_TWEETBOMB_LANGUAGE_GL","Galician");
	define("_MI_TWEETBOMB_LANGUAGE_GN","Guarani");
	define("_MI_TWEETBOMB_LANGUAGE_GU","Gujarati");
	define("_MI_TWEETBOMB_LANGUAGE_HA","Hausa");
	define("_MI_TWEETBOMB_LANGUAGE_HE","Hebrew");
	define("_MI_TWEETBOMB_LANGUAGE_HI","Hindi");
	define("_MI_TWEETBOMB_LANGUAGE_HR","Croatian");
	define("_MI_TWEETBOMB_LANGUAGE_HU","Hungarian");
	define("_MI_TWEETBOMB_LANGUAGE_HY","Armenian");
	define("_MI_TWEETBOMB_LANGUAGE_IA","Interlingua");
	define("_MI_TWEETBOMB_LANGUAGE_ID","Indonesian");
	define("_MI_TWEETBOMB_LANGUAGE_IE","Interlingue");
	define("_MI_TWEETBOMB_LANGUAGE_IK","Inupiak");
	define("_MI_TWEETBOMB_LANGUAGE_IS","Icelandic");
	define("_MI_TWEETBOMB_LANGUAGE_IT","Italian");
	define("_MI_TWEETBOMB_LANGUAGE_IU","Inuktitut");
	define("_MI_TWEETBOMB_LANGUAGE_JA","Japanese");
	define("_MI_TWEETBOMB_LANGUAGE_JW","Javanese");
	define("_MI_TWEETBOMB_LANGUAGE_KA","Georgian");
	define("_MI_TWEETBOMB_LANGUAGE_KK","Kazakh");
	define("_MI_TWEETBOMB_LANGUAGE_KL","Greenlandic");
	define("_MI_TWEETBOMB_LANGUAGE_KM","Cambodian");
	define("_MI_TWEETBOMB_LANGUAGE_KN","Kannada");
	define("_MI_TWEETBOMB_LANGUAGE_KO","Korean");
	define("_MI_TWEETBOMB_LANGUAGE_KS","Kashmiri");
	define("_MI_TWEETBOMB_LANGUAGE_KU","Kurdish");
	define("_MI_TWEETBOMB_LANGUAGE_KY","Kirghiz");
	define("_MI_TWEETBOMB_LANGUAGE_LA","Latin");
	define("_MI_TWEETBOMB_LANGUAGE_LN","Lingala");
	define("_MI_TWEETBOMB_LANGUAGE_LO","Laothian");
	define("_MI_TWEETBOMB_LANGUAGE_LT","Lithuanian");
	define("_MI_TWEETBOMB_LANGUAGE_LV","Latvian (Lettish)");
	define("_MI_TWEETBOMB_LANGUAGE_MG","Malagasy");
	define("_MI_TWEETBOMB_LANGUAGE_MI","Maori");
	define("_MI_TWEETBOMB_LANGUAGE_MK","Macedonian");
	define("_MI_TWEETBOMB_LANGUAGE_ML","Malayalam");
	define("_MI_TWEETBOMB_LANGUAGE_MN","Mongolian");
	define("_MI_TWEETBOMB_LANGUAGE_MO","Moldavian");
	define("_MI_TWEETBOMB_LANGUAGE_MR","Marathi");
	define("_MI_TWEETBOMB_LANGUAGE_MS","Malay");
	define("_MI_TWEETBOMB_LANGUAGE_MT","Maltese");
	define("_MI_TWEETBOMB_LANGUAGE_MY","Burmese");
	define("_MI_TWEETBOMB_LANGUAGE_NA","Nauru");
	define("_MI_TWEETBOMB_LANGUAGE_NE","Nepali");
	define("_MI_TWEETBOMB_LANGUAGE_NL","Dutch");
	define("_MI_TWEETBOMB_LANGUAGE_NO","Norwegian");
	define("_MI_TWEETBOMB_LANGUAGE_OC","Occitan");
	define("_MI_TWEETBOMB_LANGUAGE_OM","(Afan) Oromo");
	define("_MI_TWEETBOMB_LANGUAGE_OR","Oriya");
	define("_MI_TWEETBOMB_LANGUAGE_PA","Punjabi");
	define("_MI_TWEETBOMB_LANGUAGE_PL","Polish");
	define("_MI_TWEETBOMB_LANGUAGE_PS","Pashto (Pushto)");
	define("_MI_TWEETBOMB_LANGUAGE_PT","Portuguese");
	define("_MI_TWEETBOMB_LANGUAGE_QU","Quechua");
	define("_MI_TWEETBOMB_LANGUAGE_RM","Rhaeto-Romance");
	define("_MI_TWEETBOMB_LANGUAGE_RN","Kirundi");
	define("_MI_TWEETBOMB_LANGUAGE_RO","Romanian");
	define("_MI_TWEETBOMB_LANGUAGE_RU","Russian");
	define("_MI_TWEETBOMB_LANGUAGE_RW","Kinyarwanda");
	define("_MI_TWEETBOMB_LANGUAGE_SA","Sanskrit");
	define("_MI_TWEETBOMB_LANGUAGE_SD","Sindhi");
	define("_MI_TWEETBOMB_LANGUAGE_SG","Sangho");
	define("_MI_TWEETBOMB_LANGUAGE_SH","Serbo-Croatian");
	define("_MI_TWEETBOMB_LANGUAGE_SI","Sinhalese");
	define("_MI_TWEETBOMB_LANGUAGE_SK","Slovak");
	define("_MI_TWEETBOMB_LANGUAGE_SL","Slovenian");
	define("_MI_TWEETBOMB_LANGUAGE_SM","Samoan");
	define("_MI_TWEETBOMB_LANGUAGE_SN","Shona");
	define("_MI_TWEETBOMB_LANGUAGE_SO","Somali");
	define("_MI_TWEETBOMB_LANGUAGE_SQ","Albanian");
	define("_MI_TWEETBOMB_LANGUAGE_SR","Serbian");
	define("_MI_TWEETBOMB_LANGUAGE_SS","Siswati");
	define("_MI_TWEETBOMB_LANGUAGE_ST","Sesotho");
	define("_MI_TWEETBOMB_LANGUAGE_SU","Sundanese");
	define("_MI_TWEETBOMB_LANGUAGE_SV","Swedish");
	define("_MI_TWEETBOMB_LANGUAGE_SW","Swahili");
	define("_MI_TWEETBOMB_LANGUAGE_TA","Tamil");
	define("_MI_TWEETBOMB_LANGUAGE_TE","Telugu");
	define("_MI_TWEETBOMB_LANGUAGE_TG","Tajik");
	define("_MI_TWEETBOMB_LANGUAGE_TH","Thai");
	define("_MI_TWEETBOMB_LANGUAGE_TI","Tigrinya");
	define("_MI_TWEETBOMB_LANGUAGE_TK","Turkmen");
	define("_MI_TWEETBOMB_LANGUAGE_TL","Tagalog");
	define("_MI_TWEETBOMB_LANGUAGE_TN","Setswana");
	define("_MI_TWEETBOMB_LANGUAGE_TO","Tonga");
	define("_MI_TWEETBOMB_LANGUAGE_TR","Turkish");
	define("_MI_TWEETBOMB_LANGUAGE_TS","Tsonga");
	define("_MI_TWEETBOMB_LANGUAGE_TT","Tatar");
	define("_MI_TWEETBOMB_LANGUAGE_TW","Twi");
	define("_MI_TWEETBOMB_LANGUAGE_UG","Uighur");
	define("_MI_TWEETBOMB_LANGUAGE_UK","Ukrainian");
	define("_MI_TWEETBOMB_LANGUAGE_UR","Urdu");
	define("_MI_TWEETBOMB_LANGUAGE_UZ","Uzbek");
	define("_MI_TWEETBOMB_LANGUAGE_VI","Vietnamese");
	define("_MI_TWEETBOMB_LANGUAGE_VO","Volapuk");
	define("_MI_TWEETBOMB_LANGUAGE_WO","Wolof");
	define("_MI_TWEETBOMB_LANGUAGE_XH","Xhosa");
	define("_MI_TWEETBOMB_LANGUAGE_YI","Yiddish");
	define("_MI_TWEETBOMB_LANGUAGE_YO","Yoruba");
	define("_MI_TWEETBOMB_LANGUAGE_ZA","Zhuang");
	define("_MI_TWEETBOMB_LANGUAGE_ZH","Chinese");
	define("_MI_TWEETBOMB_LANGUAGE_ZU","Zulu");
	
	// Measurement Defines
	define("_MI_TWEETBOMB_MEASUREMENT_MI","Miles");
	define("_MI_TWEETBOMB_MEASUREMENT_KM","Kilometers");
	
	// Retweet Types
	define("_MI_TWEETBOMB_RETWEET_TYPE_MIXED", 'Include both popular and real time results');
	define("_MI_TWEETBOMB_RETWEET_TYPE_RECENT", 'Only the most recent results');
	define("_MI_TWEETBOMB_RETWEET_TYPE_POPULAR", 'Only the most popular results');

	//Type Title
	define("_MI_TWEETBOMB_CAMPAIGN_TITLE_RETWEET", 'Retweet');
	
	//Preferences
	define('_MI_TWEETBOMB_SEARCH_URL','Twitter Application JSON Search URL');
	define('_MI_TWEETBOMB_SEARCH_URL_DESC','To get a <em>search url</em> you need to check the documentation on twitter (<a href="https://dev.twitter.com/docs/api/1/get/search">Click Here</a>)');
	define('_MI_TWEETBOMB_CRON_RETWEET','Run Search and Retweet Cron');
	define('_MI_TWEETBOMB_CRON_RETWEET_DESC','Enables/Disables Search and Retweet Cron.');
	define('_MI_TWEETBOMB_DO_SEARCH','Number of seconds delay between searching and researching');
	define('_MI_TWEETBOMB_DO_SEARCH_DESC','Total number of seconds to wait before retrieve the same search.');
	define('_MI_TWEETBOMB_GATHER_ON_SEARCH','Number of results to retrieve on a search.');
	define('_MI_TWEETBOMB_GATHER_ON_SEARCH_DESC','Total number of results to retrieve on a search. (maximum 1500)');
	define('_MI_TWEETBOMB_RETWEETS_PER_SESSION','Number of retweets per cron session.');
	define('_MI_TWEETBOMB_RETWEETS_PER_SESSION_DESC','Total number of retweets to do on a cron session.');
	define('_MI_TWEETBOMB_RETWEET_ITEMS','Retweet - RSS Items (requires API)');
	define('_MI_TWEETBOMB_RETWEET_ITEMS_DESC','Number of items to return on RSS Feeds of a retweet campaign.');
	define('_MI_TWEETBOMB_RETWEET_CACHE','Retweet - Number of Seconds RSS Feed is cached! (requires API)');
	define('_MI_TWEETBOMB_RETWEET_CACHE_DESC','Total number of seconds the RSS Feed is cached for before getting the next set of retweets.');
	
	//Version 1.20
	//Preferences
	define('_MI_TWEETBOMB_ODDS_LOWER','Odds Lower Numeric Base');
	define('_MI_TWEETBOMB_ODDS_LOWER_DESC','This is the lowest number selected in a random when placing odds.');
	define('_MI_TWEETBOMB_ODDS_HIGHER','Odds Higher Numeric Base');
	define('_MI_TWEETBOMB_ODDS_HIGHER_DESC','This is the highest number selected in a random when placing odds.');
	define('_MI_TWEETBOMB_ODDS_MINIMUM','Odds Less than or Equal to Numeric Base');
	define('_MI_TWEETBOMB_ODDS_MINIMUM_DESC','When a number is alot from the odds numeric base the option will activate when less than or equal to this number.');
	define('_MI_TWEETBOMB_ODDS_MAXIMUM','Odds Greater than or Equal Numeric Base');
	define('_MI_TWEETBOMB_ODDS_MAXIMUM_DESC','When a number is alot from the odds numeric base the option will activate when greater than or equal to this number.');

	// Version 1.21
	// Preferences
	define('_MI_TWEETBOMB_LOG_RETWEET','Log Retweet');
	define('_MI_TWEETBOMB_LOG_RETWEET_DESC','Log all retweeted tweets.');
	
	// Version 1.25
	// Admin Menus
	$module_handler = xoops_gethandler('module');
	$config_handler = xoops_gethandler('config');
	$GLOBALS['twitterbombModule'] = $module_handler->getByDirname('twitterbomb');
	if (is_object($GLOBALS['twitterbombModule'])) {
		$GLOBALS['twitterbombModuleConfig'] = $config_handler->getConfigList($GLOBALS['twitterbombModule']->getVar('mid'));
		define('_MI_TWEETBOMB_TITLE_ADMENU0','Dashboard');
		define('_MI_TWEETBOMB_ICON_ADMENU0','../../'.$GLOBALS['twitterbombModule']->getInfo('icons32').'/about.png');
		define('_MI_TWEETBOMB_LINK_ADMENU0','admin/index.php?op=dashboard');
		define('_MI_TWEETBOMB_TITLE_ADMENU1','Campaign Trail');
		define('_MI_TWEETBOMB_ICON_ADMENU1','../../'.$GLOBALS['twitterbombModule']->getInfo('icons32').'/twitterbomb.campaigns.png');
		define('_MI_TWEETBOMB_LINK_ADMENU1','admin/index.php?op=campaign&fct=list');
		define('_MI_TWEETBOMB_TITLE_ADMENU2','Categories');
		define('_MI_TWEETBOMB_ICON_ADMENU2','../../'.$GLOBALS['twitterbombModule']->getInfo('icons32').'/twitterbomb.categories.png');
		define('_MI_TWEETBOMB_LINK_ADMENU2','admin/index.php?op=category&fct=list');
		define('_MI_TWEETBOMB_TITLE_ADMENU3','Keywords/Key Phrases');
		define('_MI_TWEETBOMB_ICON_ADMENU3','../../'.$GLOBALS['twitterbombModule']->getInfo('icons32').'/twitterbomb.keywords.png');
		define('_MI_TWEETBOMB_LINK_ADMENU3','admin/index.php?op=keywords&fct=list');
		define('_MI_TWEETBOMB_TITLE_ADMENU4','Sentence Matrix');
		define('_MI_TWEETBOMB_ICON_ADMENU4','../../'.$GLOBALS['twitterbombModule']->getInfo('icons32').'/twitterbomb.sentence.png');
		define('_MI_TWEETBOMB_LINK_ADMENU4','admin/index.php?op=base_matrix&fct=list');
		define('_MI_TWEETBOMB_TITLE_ADMENU5','Twitter Username');
		define('_MI_TWEETBOMB_ICON_ADMENU5','../../'.$GLOBALS['twitterbombModule']->getInfo('icons32').'/twitterbomb.usernames.png');
		define('_MI_TWEETBOMB_LINK_ADMENU5','admin/index.php?op=usernames&fct=list');
		define('_MI_TWEETBOMB_TITLE_ADMENU6','Search URLS');
		define('_MI_TWEETBOMB_ICON_ADMENU6','../../'.$GLOBALS['twitterbombModule']->getInfo('icons32').'/twitterbomb.urls.png');
		define('_MI_TWEETBOMB_LINK_ADMENU6','admin/index.php?op=urls&fct=list');
		define('_MI_TWEETBOMB_TITLE_ADMENU7','Tweet Scheduler');
		define('_MI_TWEETBOMB_ICON_ADMENU7','../../'.$GLOBALS['twitterbombModule']->getInfo('icons32').'/twitterbomb.scheduler.png');
		define('_MI_TWEETBOMB_LINK_ADMENU7','admin/index.php?op=scheduler&fct=list');
		define('_MI_TWEETBOMB_TITLE_ADMENU8','Search & Retweet');
		define('_MI_TWEETBOMB_ICON_ADMENU8','../../'.$GLOBALS['twitterbombModule']->getInfo('icons32').'/twitterbomb.retweet.png');
		define('_MI_TWEETBOMB_LINK_ADMENU8','admin/index.php?op=retweet&fct=list');
		define('_MI_TWEETBOMB_TITLE_ADMENU9','Search & Reply');
		define('_MI_TWEETBOMB_ICON_ADMENU9','../../'.$GLOBALS['twitterbombModule']->getInfo('icons32').'/twitterbomb.reply.png');
		define('_MI_TWEETBOMB_LINK_ADMENU9','admin/index.php?op=replies&fct=list');
		define('_MI_TWEETBOMB_TITLE_ADMENU10','Mention & Reply');
		define('_MI_TWEETBOMB_ICON_ADMENU10','../../'.$GLOBALS['twitterbombModule']->getInfo('icons32').'/twitterbomb.mentions.png');
		define('_MI_TWEETBOMB_LINK_ADMENU10','admin/index.php?op=mentions&fct=list');
		define('_MI_TWEETBOMB_TITLE_ADMENU11','Picture Crawler');
		define('_MI_TWEETBOMB_ICON_ADMENU11','../../'.$GLOBALS['twitterbombModule']->getInfo('icons32').'/twitterbomb.pictures.png');
		define('_MI_TWEETBOMB_LINK_ADMENU11','admin/index.php?op=pictures');
		define('_MI_TWEETBOMB_TITLE_ADMENU12','About');
		define('_MI_TWEETBOMB_ICON_ADMENU12','../../'.$GLOBALS['twitterbombModule']->getInfo('icons32').'/about.png');
		define('_MI_TWEETBOMB_LINK_ADMENU12','admin/index.php?op=about');
		define('_MI_TWEETBOMB_TITLE_ADMENU13','Tweet Log');
		define('_MI_TWEETBOMB_ICON_ADMENU13','../../'.$GLOBALS['twitterbombModule']->getInfo('icons32').'/twitterbomb.logs.png');
		define('_MI_TWEETBOMB_LINK_ADMENU13','admin/index.php?op=log');	
		define('_MI_TWEETBOMB_TITLE_ADMENU14','Preferences');
		define('_MI_TWEETBOMB_ICON_ADMENU14','../../'.$GLOBALS['twitterbombModule']->getInfo('icons32').'/twitterbomb.preferences.png');
		define('_MI_TWEETBOMB_LINK_ADMENU14','../system/admin.php?fct=preferences&op=showmod&mod='.$GLOBALS['twitterbombModule']->getVar('mid'));
		
	}
	
	// version 1.27
	// preferences
	define('_MI_TWEETBOMB_MAXIMUM_SEARCH_PAGES','Maximum number of search pages to crawl when searchign twitter.');
	define('_MI_TWEETBOMB_MAXIMUM_SEARCH_PAGES_DESC','This is the maximum number of pages crawled on twitter when searching for a term.');
	define('_MI_TWEETBOMB_CURL_CONNECT_TIMEOUT','Curl Connection Timeout');
	define('_MI_TWEETBOMB_CURL_CONNECT_TIMEOUT_DESC','Number of seconds before cURL Timesout when connecting.');
	define('_MI_TWEETBOMB_CURL_TIMEOUT','Curl Timeout');
	define('_MI_TWEETBOMB_CURL_TIMEOUT_DESC','Number of seconds before cURL Timesout when functioning.');
	define('_MI_TWEETBOMB_POSTITIVE_EXCEPTION_MATCH','Positive Execption Matching Percentile');
	define('_MI_TWEETBOMB_POSTITIVE_EXCEPTION_MATCH_DESC','Number of positive exceptions by the number found must be less than this percentile for a postive match.');
	define('_MI_TWEETBOMB_NEGATIVE_EXCEPTION_MATCH','Negative Execption Matching Percentile');
	define('_MI_TWEETBOMB_NEGATIVE_EXCEPTION_MATCH_DESC','Number of negative exceptions by the number found must be greater than this percentile for a postive match.');
	
	// Version 1.28
	define('_MI_TWEETBOMB_CAMPAIGN_TITLE_REPLY','Reply');
	define('_MI_TWEETBOMB_CAMPAIGN_TITLE_MENTIONS','Mentions');
	define('_MI_TWEETBOMB_REPLY_BOMB','Reply Bombing: %s Campaign');

	//Preferences
	define('_MI_TWEETBOMB_CRON_REPLIES','Run generate replies script on cronjob?');
	define('_MI_TWEETBOMB_CRON_REPLIES_DESC','Whether you want replies to be cronned.');
	define('_MI_TWEETBOMB_CRON_MENTIONS','Run generate mentions script on cronjob?');
	define('_MI_TWEETBOMB_CRON_MENTIONS_DESC','Whether you want mentions to be cronned.');
	define('_MI_TWEETBOMB_REPLIES_ITEMS','Replies - RSS Items');
	define('_MI_TWEETBOMB_REPLIES_ITEMS_DESC','Number of items to return on RSS Feeds of a reply campaign.');
	define('_MI_TWEETBOMB_MENTIONS_ITEMS','Mentions - RSS Items');
	define('_MI_TWEETBOMB_MENTIONS_ITEMS_DESC','Number of items to return on RSS Feeds of a mention campaign.');
	
	// Version 1.32
	define('_MI_TWEETBOMB_SENTENCE_MAXIMUM_LENGHT','Maximum character length of generated phrase bomb!');
	define('_MI_TWEETBOMB_SENTENCE_MAXIMUM_LENGHT_DESC','This is the maximum characters in length a phrase bomb can be, otherwise cut and "..." placed at the end.');
	define('_MI_TWEETBOMB_MYALBUMP_DIRNAME','Myalbum 3.xx Dirname for picture crawl');
	define('_MI_TWEETBOMB_MYALBUMP_DIRNAME_DESC','This is the Dirname for myalbum-p version 3 or later for picture crawling!');
	
	define('_MI_TWEETBOMB_CAMPAIGN_TITLE_PICTURES','Picture Crawl');
	
	define('_MI_TWEETBOMB_PICTURES_CACHE','Pictures Data Cache');
	define('_MI_TWEETBOMB_PICTURES_CACHE_DESC','Number of Second Data is Cached For');
	define('_MI_TWEETBOMB_PICTURES_PER_SESSION','Number of Pictures per Cron Session');
	define('_MI_TWEETBOMB_PICTURES_PER_SESSION_DESC','Total Number of URLs to process for images per cron session');
	define('_MI_TWEETBOMB_PICTURES_ITEMS','Pictures Items');
	define('_MI_TWEETBOMB_PICTURES_ITEMS_DESC','Number of Balancing Items per session of cron');
	define('_MI_TWEETBOMB_CRON_PICTURES','Cron Pictures');
	define('_MI_TWEETBOMB_CRON_PICTURES_DESC','Whether the cron downloads pictures?');
	define('_MI_TWEETBOMB_CRON_PICTURES','Cron Pictures');
	define('_MI_TWEETBOMB_CRON_PICTURES_DESC','Whether the cron downloads pictures?');
	define('_MI_TWEETBOMB_MYALBUMP_STATUS_UNAPPROVED','Unapproved!');
	define('_MI_TWEETBOMB_MYALBUMP_STATUS_APPROVED','Approved');
	define('_MI_TWEETBOMB_MYALBUMP_STATUS','Image Status after Imported!');
	define('_MI_TWEETBOMB_MYALBUMP_STATUS_DESC','Approved means it will be immediately public, unapproved means you have to manage the images!');
	?>