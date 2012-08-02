    elgg.provide('hj.comments');

    /**
     *  Initialize hypeComments JS
     */
    hj.comments.init = function() {
        hj.comments.refreshLikes();
        hj.comments.refreshComments();

        // Uncomment the following line to enable timed refresh of comments and likes
        //hj.comments.timedRefresh(15000);
        
        var bar = $('div.hj-comments-bar');
        
        /**
         * Iterate through all containers and place comments and likes if exist
         */
        bar.each(function(key){
            var id = $(this).attr('id');
            var commentsContainer = $('.hj-comments-item-comments-container', $(this));
            //commentsContainer.hide();

            var commentButton = $('.hj-comments-item-comments', $(this));
            commentButton.click(function(){
                commentsContainer.toggle();
            });
        });
    };
    
    hj.comments.getLikes = function (guids) {
        var bar = $('div.hj-comments-bar');
        var temp;
        elgg.action('action/hjlikes/get', {
            data: {
                guids: guids.join(',')
            },
            success: function(likes) {
                bar.each(function(key){
                    var id = $(this).attr('id');
                    var likesContainer = $('.hj-comments-item-like-bar', $(this));

                    var likesButtonContainer = $('.hj-comments-item-like', $(this));
                    var current_user = elgg.get_logged_in_user_entity();
                    var current_likes = likes[key].likes;
                    var like_status = false;

                    if (current_likes instanceof Object) {
                        for (var i=0; i<current_likes.length;i++) {
                            if (current_likes[i].username == current_user.name) {
                                like_status = true;
                            }
                        }
                    }
                    if (like_status) {
                        likesButtonContainer.removeClass('like').addClass('unlike');
                        likesButtonContainer.children('a').html(elgg.echo('hj:comments:unlikebutton'));
                        likesButtonContainer.unbind().click(function(){
                            hj.comments.unlikeThis(id);
                        });
                    } else {
                        likesButtonContainer.removeClass('unlike').addClass('like');
                        likesButtonContainer.children('a').html(elgg.echo('hj:comments:likebutton'));
                        likesButtonContainer.unbind().click(function(){
                            hj.comments.likeThis(id);
                        });
                    }

                    hj.comments.getLikesForObject(likes, key, likesContainer);
                });
            }
            
        });
    }

    hj.comments.getLikesForObject = function(likes, key, result_container) {
        var objectLikes = likes[key].likes;
        if (objectLikes instanceof Object) {
            var text = hj.comments.getLikesLanguage(objectLikes);
            result_container.html(text[0]);
            $('a.likes_short', result_container).click(function() {
                $(this).html(text[1]);
            });
        } else {
            result_container.hide();
        }
    }

    hj.comments.getLikesLanguage = function(likes) {
        
        var text_owner = elgg.echo('hj:comments:lang:you');
        var text_and = elgg.echo('hj:comments:lang:and');
        var text_others = elgg.echo('hj:comments:lang:others');
        var text_others_one = elgg.echo('hj:comments:lang:othersone');
        var text_people = elgg.echo('hj:comments:lang:people');
        var text_people_one = elgg.echo('hj:comments:lang:peopleone');
        var text_likethis = elgg.echo('hj:comments:lang:likethis');
        var text_likesthis = elgg.echo('hj:comments:lang:likesthis');
        
        var current_user = elgg.get_logged_in_user_entity();

        var prefix = '';
        var html = new Array();
        $.each(likes, function(key, val) {
            if (likes[key].username == current_user.name) {
                prefix = text_owner;
            } else {
                html.push('<span class="likes_names"><a href="' + likes[key].url + '">' + likes[key].username + '</a></span>');
            }
        });

        var string = '';
        var likes_long = html.join(', ');

        if (prefix !== '' && html.length == 0) {
            string = prefix + text_likethis;
        } else if (prefix !== '' && html.length == 1) {
            var likes_short = '<a class="likes_short" href="javascript:void(0)">' + html.length + ' ' + text_others_one + '</a>';
            string = prefix + text_and + likes_short + ' ' + text_likethis;
        } else if (prefix !== '' && html.length > 1) {
            var likes_short = '<a class="likes_short" href="javascript:void(0)">' + html.length + ' ' + text_others + '</a>';
            string = prefix + text_and + likes_short + ' ' + text_likethis;
        } else if (prefix == '' && html.length == 1) {
            var likes_short = '<a class="likes_short" href="javascript:void(0)">' + html.length + ' ' + text_people_one + '</a>';
            string = likes_short + ' ' + text_likesthis;
        } else if (prefix == '' && html.length > 1) {
            var likes_short = '<a class="likes_short" href="javascript:void(0)">' + html.length + ' ' + text_people + '</a>';
            string = likes_short + ' ' + text_likethis;
        }
        
        var result = [string, likes_long];
        return result;
    }
    
    hj.comments.likeThis = function(guid) {
        elgg.action('action/hjlikes/save', {
            data: {
                guid: guid
            },
            success: function(data) {
                hj.comments.refreshLikes()
            }
        });   
    }

    hj.comments.unlikeThis = function(guid) {
        elgg.action('action/hjlikes/delete', {
            data: {
                guid: guid
            },
            success: function(data) {
                hj.comments.refreshLikes()
            }
        });
    }

    hj.comments.getComments = function(guids) {
        var bar = $('div.hj-comments-bar');
        var temp;
        elgg.action('action/hjcomments/get', {
            data: {
                guids: guids.join(',')
            },
            success: function(comments) {
                bar.each(function(key) {
                    var id = $(this).attr('id');
                    var commentsBar = $('.hj-comments-item-comments-bar', $(this));
                    var commentsContainer = $('.hj-comments-item-comments-container', $(this));
                    hj.comments.getCommentsForObject(comments, key, commentsBar, commentsContainer);
                });
            }
        });
    }

    hj.comments.getCommentsForObject = function(comments, key, comments_bar, comments_container) {
        var objectComments = comments[key].comments;
        var objectCommentInput = comments[key].input;
        var new_comment = objectCommentInput;
        comments_container.html(new_comment);
        hj.comments.bindNewComment(comments_container);
        if (objectComments instanceof Object) {
            var html = hj.comments.showComments(objectComments);
            comments_container.html(html[1] + new_comment);
            if (html[0] !== '') {
                comments_bar.html(html[0]);
                comments_bar.unbind().click(function(){
                    $(this).hide();
                    comments_container.html(html[2] + html[1] + new_comment);
                    hj.comments.bindDelete(comments_container);
                    hj.comments.bindNewComment(comments_container);
                });
            } else {
                comments_bar.hide();
            }
            comments_container.show();
            hj.comments.bindDelete(comments_container);
            hj.comments.bindNewComment(comments_container);
        } else {
            comments_bar.hide();
        }
    }

    hj.comments.showComments = function(comments) {
        var comments_array = new Array();
        $.each(comments, function(key, val){
            comments_array.push('<div id="' + comments[key].id + '" class="hj-comments-item-comment">' +
                '<div class="hj-comments-item-comment-icon left">' + comments[key].icon + '</div>' +
                '<div class="hj-comments-item-comment-content left">' + comments[key].owner +
                '<div class="hj-comments-item-comment-value left">' + comments[key].text + '</div>' +
                '<div class="clearfloat"></div>' +
                '<div class="hj-comments-item-comment-extras left><span>' + comments[key].time + '</span>' +
                '<span>' + comments[key].deletebutton + '</span>' +
                '</div>' + '</div>' +
                '<div class="clearfloat"></div>' +
                '</div>');
        });

        var space = " ";
        var comments_count = comments_array.length;
        var show_all = '<a href="javascript:void(0)" class="hj-comments-item-comments-show-all">' + elgg.echo('hj:comments:viewall') + space + comments_array.length + space + elgg.echo('hj:comments:comments');
        var recent_comments = '';
        var hidden_comments = '';

        var i;
        for (i=0;i<=comments_count-1;i++) {
            if (i == comments_count - 1 || i == comments_count - 2) {
                recent_comments = recent_comments + comments_array[i];
            } else {
                hidden_comments = hidden_comments + comments_array[i];
            }
        }
        if (comments_count <= 2) {
            var result = ['', recent_comments, ''];
            return result;
        } else {
            var result = [show_all, recent_comments, hidden_comments];
            return result;
        }
    }

    hj.comments.refreshLikes = function() {
        var bar = $('div.hj-comments-bar');

        var guids = new Array();

        bar.each(function(key){
            var id = $(this).attr('id');
            $(this).attr('key', key);
            var ajax_loader = '<div class="hj-ajax-loader hj-loader-bar"></div>';
            var likesContainer = $('.hj-comments-item-like-bar', $(this));
            likesContainer.show().html(ajax_loader);
            guids.push(id);
        });

        hj.comments.getLikes(guids);

        return true;
    }

    hj.comments.refreshComments = function() {
        var bar = $('div.hj-comments-bar');

        var guids = new Array();

        bar.each(function(key){
            var id = $(this).attr('id');
            $(this).attr('key', key);
            var ajax_loader = '<div class="hj-ajax-loader hj-loader-bar"></div>';
            var commentsBar = $('.hj-comments-item-comments-bar', $(this));
            var commentsContainer = $('.hj-comments-item-comments-container', $(this));
            if (commentsContainer.html() == '') {
                commentsBar.show().html(ajax_loader);
            }
            //commentsContainer.hide();
            guids.push(id);
        });

        hj.comments.getComments(guids);

       
    }

    hj.comments.bindDelete = function(comments_bar, comments_container) {
        var deleteButton = $('.comment-delete', comments_container);
        deleteButton.unbind().click(function(){
            hj.comments.deleteComment($(this).attr('id'));
            var ajax_loader = '<div class="hj-ajax-loader hj-loader-bar"></div>';
            $(this).html(ajax_loader);
            //hj.comments.refreshComments();
        });
    }

    hj.comments.deleteComment = function(id) {
        elgg.action('action/hjcomments/delete', {
            data: {
                id: id
            }, 
            success: function() {
                hj.comments.refreshComments();
            }
        });
    }

    hj.comments.bindNewComment = function(comments_container) {
        var comment_input = $('input[name=hj-comments-item-comment-input]', comments_container);
        var temp_value = comment_input.val();
        comment_input
        .focus(function() {
            $(this).val('');
        })
        .keydown(function(event) {
            if (event.keyCode == '13') {
                if ($(this).val() !== '') {
                    var ajax_loader = '<div class="hj-ajax-loader hj-loader-bar"></div>';
                    comment_input.parent().html(ajax_loader);
                    hj.comments.submitNewComment($(this).val(), $(this).attr('id'));
                    //hj.comments.refreshComments();
                } else {
                    elgg.register_error(elgg.echo('hj:comments:commentmissing'));
                }
            }
        });
    }

    hj.comments.submitNewComment = function(value, entity) {
        elgg.action('action/hjcomments/save', {
            data: {
                entity_guid: entity,
                value: value
            },
            success: function() { 
                hj.comments.refreshComments(); 
            }
        });
    }

    /**
     * Add timed refresh of comments and likes
     *
     * @param {int} time
     */
    hj.comments.timedRefresh = function(time) {
        var refresh = setInterval(function(){
            hj.comments.refreshLikes();
            hj.comments.refreshComments();
        }, time);
    }
    
    elgg.register_hook_handler('init', 'system', hj.comments.init);