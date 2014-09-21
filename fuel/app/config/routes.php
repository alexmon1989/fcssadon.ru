<?php
return array(
	'_root_'  => 'main/main/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
    
        'news' => 'main/articles/news/index',
        'news/shahter' => 'main/articles/news/index',
        'news/shahter/page/(:num)' => 'main/articles/news/index/$1',
        'news/shahter/view/(:num)' => 'main/articles/news/view/$1',
    
        'news/interviews' => 'main/articles/interviews/index',
        'news/interviews/page/(:num)' => 'main/articles/interviews/index/$1',
        'news/interviews/view/(:num)' => 'main/articles/interviews/view/$1',
    
        'news/fond' => 'main/articles/fond/index',
        'news/fond/page/(:num)' => 'main/articles/fond/index/$1',
        'news/fond/view/(:num)' => 'main/articles/fond/view/$1',
    
        'media' => 'main/media/photos/categories/index',
        'media/photos' => 'main/media/photos/categories/index',
        'media/photos/categories/index/(:num)' => 'main/media/photos/categories/index/$1',
        'media/photos/categories/view/(:num)' => 'main/media/photos/categories/view/$1',
        'media/photos/categories/view/(:num)/(:num)' => 'main/media/photos/categories/view/$1/$2',
        
        'media/videos' => 'main/media/videos/index',
        'media/videos/(:num)' => 'main/media/videos/index/$1',
            
        'team/core' => 'main/players/core/index',    
        'team/core/view/(:num)' => 'main/players/core/view/$1',    
        'team/past' => 'main/players/past/index',    
        'team/past/view/(:num)' => 'main/players/past/view/$1',
    
        'team/staff' => 'main/staff/index',
        'team/staff/view/(:num)' => 'main/staff/view/$1',
    
        'team/calendar' => 'main/calendar/index',    
        'team/calendar/view/(:num)' => 'main/calendar/view/$1',    
    
        'matches/(:num)' => 'main/matches/index/$1',    
    
        'contacts' => 'main/contacts/index',
    
        'table/(:num)' => 'main/table/index/$1',
            
        'club/management' => 'main/club/view/36',
        'club/history' => 'main/club/view/37',
        'club/sponsors' => 'main/club/view/38',
        'club/stadium' => 'main/club/view/39',
    
        'admin/articles/categories' => 'admin/categories',
        'admin/articles/categories/create' => 'admin/categories/create',
        'admin/articles/categories/edit/(:num)' => 'admin/categories/edit/$1',
        'admin/articles/categories/delete/(:num)' => 'admin/categories/delete/$1'
);