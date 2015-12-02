<?php /* #?ini charset="utf-8"?

[block_campaign]
Source=block/view/view.tpl
MatchFile=block/campaign.tpl
Subdir=templates
Match[type]=Campaign
Match[view]=default

[block_main_story_highlighted]
Source=block/view/view.tpl
MatchFile=block/main_story_highlighted.tpl
Subdir=templates
Match[type]=MainStory
Match[view]=highligted

[block_main_story_background_image]
Source=block/view/view.tpl
MatchFile=block/main_story_background_image.tpl
Subdir=templates
Match[type]=MainStory
Match[view]=default

[block_1_column_2_rows]
Source=block/view/view.tpl
MatchFile=block/content_grid_1col_2rows.tpl
Subdir=templates
Match[type]=ContentGrid
Match[view]=default

[block_1_column_4_rows]
Source=block/view/view.tpl
MatchFile=block/content_grid_1col_4rows.tpl
Subdir=templates
Match[type]=ContentGrid
Match[view]=1_column_4_rows

[block_2_columns_2_rows]
Source=block/view/view.tpl
MatchFile=block/content_grid_2cols_2rows.tpl
Subdir=templates
Match[type]=ContentGrid
Match[view]=2_columns_2_rows

[block_3_columns_1_row]
Source=block/view/view.tpl
MatchFile=block/content_grid_3cols_1row.tpl
Subdir=templates
Match[type]=ContentGrid
Match[view]=3_columns_1_row

[block_3_columns_2_rows]
Source=block/view/view.tpl
MatchFile=block/content_grid_3cols_2rows.tpl
Subdir=templates
Match[type]=ContentGrid
Match[view]=3_columns_2_rows

[block_4_columns_1_row]
Source=block/view/view.tpl
MatchFile=block/content_grid_4cols_1row.tpl
Subdir=templates
Match[type]=ContentGrid
Match[view]=4_columns_1_row

[block_4_columns_2_rows]
Source=block/view/view.tpl
MatchFile=block/content_grid_4cols_2rows.tpl
Subdir=templates
Match[type]=ContentGrid
Match[view]=4_columns_2_rows

[block_gallery]
Source=block/view/view.tpl
MatchFile=block/gallery.tpl
Subdir=templates
Match[type]=Gallery
Match[view]=default

[block_banner_internal]
Source=block/view/view.tpl
MatchFile=block/banner_internal.tpl
Subdir=templates
Match[type]=Banner
Match[view]=default

[block_banner_external]
Source=block/view/view.tpl
MatchFile=block/banner_external.tpl
Subdir=templates
Match[type]=Banner
Match[view]=external

[block_banner_code]
Source=block/view/view.tpl
MatchFile=block/banner_code.tpl
Subdir=templates
Match[type]=Banner
Match[view]=code

[block_video]
Source=block/view/view.tpl
MatchFile=block/video.tpl
Subdir=templates
Match[type]=Video
Match[view]=default

[block_tag_cloud]
Source=block/view/view.tpl
MatchFile=block/tag_cloud.tpl
Subdir=templates
Match[type]=TagCloud
Match[view]=default

[block_poll]
Source=block/view/view.tpl
MatchFile=block/poll.tpl
Subdir=templates
Match[type]=Poll
Match[view]=default

[block_item_list]
Source=block/view/view.tpl
MatchFile=block/item_list.tpl
Subdir=templates
Match[type]=ItemList
Match[view]=default

[block_feed_reader]
Source=block/view/view.tpl
MatchFile=block/feed_reader.tpl
Subdir=templates
Match[type]=FeedReader
Match[view]=default

[block_feedback_form]
Source=block/view/view.tpl
MatchFile=block/feedback_form.tpl
Subdir=templates
Match[type]=FeedbackForm
Match[view]=default

[block_highlighted_item]
Source=block/view/view.tpl
MatchFile=block/highlighted_item.tpl
Subdir=templates
Match[type]=HighlightedItem
Match[view]=default

[block_item_campaign_article]
Source=node/view/block_item_campaign.tpl
MatchFile=block_item_campaign/article.tpl
Subdir=templates
Match[class_identifier]=article

[block_item_campaign_image]
Source=node/view/block_item_campaign.tpl
MatchFile=block_item_campaign/image.tpl
Subdir=templates
Match[class_identifier]=image

[block_item_article]
Source=node/view/block_item.tpl
MatchFile=block_item/article.tpl
Subdir=templates
Match[class_identifier]=article

[block_item_comment]
Source=node/view/block_item.tpl
MatchFile=block_item/comment.tpl
Subdir=templates
Match[class_identifier]=comment

[block_item_image]
Source=node/view/block_item.tpl
MatchFile=block_item/image.tpl
Subdir=templates
Match[class_identifier]=image

[block_item_product]
Source=node/view/block_item.tpl
MatchFile=block_item/product.tpl
Subdir=templates
Match[class_identifier]=product

[block_item_call_to_action]
Source=node/view/block_item.tpl
MatchFile=block_item/call_to_action.tpl
Subdir=templates
Match[class_identifier]=call_to_action

[call_to_action_mail]
Source=content/collectedinfomail/form.tpl
MatchFile=collectedinfomail/call_to_action.tpl
Subdir=templates
Match[class_identifier]=call_to_action

[full_article]
Source=node/view/full.tpl
MatchFile=full/article.tpl
Subdir=templates
Match[class_identifier]=article

[full_geo_article]
Source=node/view/full.tpl
MatchFile=full/geo_article.tpl
Subdir=templates
Match[class_identifier]=geo_article

[full_article_mainpage]
Source=node/view/full.tpl
MatchFile=full/article_mainpage.tpl
Subdir=templates
Match[class_identifier]=article_mainpage

[full_article_subpage]
Source=node/view/full.tpl
MatchFile=full/article_subpage.tpl
Subdir=templates
Match[class_identifier]=article_subpage

[full_banner]
Source=node/view/full.tpl
MatchFile=full/banner.tpl
Subdir=templates
Match[class_identifier]=banner

[full_blog]
Source=node/view/full.tpl
MatchFile=full/blog.tpl
Subdir=templates
Match[class_identifier]=blog

[full_blog_post]
Source=node/view/full.tpl
MatchFile=full/blog_post.tpl
Subdir=templates
Match[class_identifier]=blog_post

[full_call_to_action]
Source=node/view/full.tpl
MatchFile=full/call_to_action.tpl
Subdir=templates
Match[class_identifier]=call_to_action

[full_call_to_action_feedback]
Source=node/view/full.tpl
MatchFile=full/call_to_action_feedback.tpl
Subdir=templates
Match[class_identifier]=call_to_action_feedback

[full_comment]
Source=node/view/full.tpl
MatchFile=full/comment.tpl
Subdir=templates
Match[class_identifier]=comment

[full_wiki_page]
Source=node/view/full.tpl
MatchFile=full/wiki_page.tpl
Subdir=templates
Match[class_identifier]=wiki_page

[full_event_calendar]
Source=node/view/full.tpl
MatchFile=full/event_calendar.tpl
Subdir=templates
Match[class_identifier]=event_calendar

[full_event]
Source=node/view/full.tpl
MatchFile=full/event.tpl
Subdir=templates
Match[class_identifier]=event

[full_feedback_form]
Source=node/view/full.tpl
MatchFile=full/feedback_form.tpl
Subdir=templates
Match[class_identifier]=feedback_form

[full_file]
Source=node/view/full.tpl
MatchFile=full/file.tpl
Subdir=templates
Match[class_identifier]=file

[full_flash]
Source=node/view/full.tpl
MatchFile=full/flash.tpl
Subdir=templates
Match[class_identifier]=flash

[full_flash_player]
Source=node/view/full.tpl
MatchFile=full/flash_player.tpl
Subdir=templates
Match[class_identifier]=flash_player

[full_flash_recorder]
Source=node/view/full.tpl
MatchFile=full/flash_recorder.tpl
Subdir=templates
Match[class_identifier]=flash_recorder

[full_folder]
Source=node/view/full.tpl
MatchFile=full/folder.tpl
Subdir=templates
Match[class_identifier]=folder

[full_forum]
Source=node/view/full.tpl
MatchFile=full/forum.tpl
Subdir=templates
Match[class_identifier]=forum

[full_forum_reply]
Source=node/view/full.tpl
MatchFile=full/forum_reply.tpl
Subdir=templates
Match[class_identifier]=forum_reply

[full_forum_topic]
Source=node/view/full.tpl
MatchFile=full/forum_topic.tpl
Subdir=templates
Match[class_identifier]=forum_topic

[full_forums]
Source=node/view/full.tpl
MatchFile=full/forums.tpl
Subdir=templates
Match[class_identifier]=forums

[full_landing_page]
Source=node/view/full.tpl
MatchFile=full/landing_page.tpl
Subdir=templates
Match[class_identifier]=landing_page

[full_gallery]
Source=node/view/full.tpl
MatchFile=full/gallery.tpl
Subdir=templates
Match[class_identifier]=gallery

[full_image]
Source=node/view/full.tpl
MatchFile=full/image.tpl
Subdir=templates
Match[class_identifier]=image

[full_infobox]
Source=node/view/full.tpl
MatchFile=full/infobox.tpl
Subdir=templates
Match[class_identifier]=infobox

[full_link]
Source=node/view/full.tpl
MatchFile=full/link.tpl
Subdir=templates
Match[class_identifier]=link

[full_multicalendar]
Source=node/view/full.tpl
MatchFile=full/multicalendar.tpl
Subdir=templates
Match[class_identifier]=multicalendar

[full_poll]
Source=node/view/full.tpl
MatchFile=full/poll.tpl
Subdir=templates
Match[class_identifier]=poll

[full_product]
Source=node/view/full.tpl
MatchFile=full/product.tpl
Subdir=templates
Match[class_identifier]=product

[full_quicktime]
Source=node/view/full.tpl
MatchFile=full/quicktime.tpl
Subdir=templates
Match[class_identifier]=quicktime

[full_real_video]
Source=node/view/full.tpl
MatchFile=full/real_video.tpl
Subdir=templates
Match[class_identifier]=real_video

[full_silverlight]
Source=node/view/full.tpl
MatchFile=full/silverlight.tpl
Subdir=templates
Match[class_identifier]=silverlight

[full_windows_media]
Source=node/view/full.tpl
MatchFile=full/windows_media.tpl
Subdir=templates
Match[class_identifier]=windows_media

[full_video]
Source=node/view/full.tpl
MatchFile=full/video.tpl
Subdir=templates
Match[class_identifier]=video

[gallery_item_video]
Source=node/view/gallery_item.tpl
MatchFile=gallery_item/video.tpl
Subdir=templates
Match[class_identifier]=video

[gallery_viewer_video]
Source=node/view/gallery_viewer.tpl
MatchFile=gallery_viewer/video.tpl
Subdir=templates
Match[class_identifier]=video

[line_article]
Source=node/view/line.tpl
MatchFile=line/article.tpl
Subdir=templates
Match[class_identifier]=article

[line_geo_article]
Source=node/view/line.tpl
MatchFile=line/geo_article.tpl
Subdir=templates
Match[class_identifier]=geo_article

[line_article_mainpage]
Source=node/view/line.tpl
MatchFile=line/article_mainpage.tpl
Subdir=templates
Match[class_identifier]=article_mainpage

[line_article_subpage]
Source=node/view/line.tpl
MatchFile=line/article_subpage.tpl
Subdir=templates
Match[class_identifier]=article_subpage

[line_banner]
Source=node/view/line.tpl
MatchFile=line/banner.tpl
Subdir=templates
Match[class_identifier]=banner

[line_blog]
Source=node/view/line.tpl
MatchFile=line/blog.tpl
Subdir=templates
Match[class_identifier]=blog

[line_blog_post]
Source=node/view/line.tpl
MatchFile=line/blog_post.tpl
Subdir=templates
Match[class_identifier]=blog_post

[line_comment]
Source=node/view/line.tpl
MatchFile=line/comment.tpl
Subdir=templates
Match[class_identifier]=comment

[line_wiki_page]
Source=node/view/line.tpl
MatchFile=line/wiki_page.tpl
Subdir=templates
Match[class_identifier]=wiki_page

[line_event_calendar]
Source=node/view/line.tpl
MatchFile=line/event_calendar.tpl
Subdir=templates
Match[class_identifier]=event_calendar

[line_event]
Source=node/view/line.tpl
MatchFile=line/event.tpl
Subdir=templates
Match[class_identifier]=event

[line_feedback_form]
Source=node/view/line.tpl
MatchFile=line/feedback_form.tpl
Subdir=templates
Match[class_identifier]=feedback_form

[line_file]
Source=node/view/line.tpl
MatchFile=line/file.tpl
Subdir=templates
Match[class_identifier]=file

[line_flash]
Source=node/view/line.tpl
MatchFile=line/flash.tpl
Subdir=templates
Match[class_identifier]=flash

[line_folder]
Source=node/view/line.tpl
MatchFile=line/folder.tpl
Subdir=templates
Match[class_identifier]=folder

[line_forum]
Source=node/view/line.tpl
MatchFile=line/forum.tpl
Subdir=templates
Match[class_identifier]=forum

[line_forum_reply]
Source=node/view/line.tpl
MatchFile=line/forum_reply.tpl
Subdir=templates
Match[class_identifier]=forum_reply

[line_forum_topic]
Source=node/view/line.tpl
MatchFile=line/forum_topic.tpl
Subdir=templates
Match[class_identifier]=forum_topic

[line_forums]
Source=node/view/line.tpl
MatchFile=line/forums.tpl
Subdir=templates
Match[class_identifier]=forums

[line_gallery]
Source=node/view/line.tpl
MatchFile=line/gallery.tpl
Subdir=templates
Match[class_identifier]=gallery

[line_image]
Source=node/view/line.tpl
MatchFile=line/image.tpl
Subdir=templates
Match[class_identifier]=image

[line_infobox]
Source=node/view/line.tpl
MatchFile=line/infobox.tpl
Subdir=templates
Match[class_identifier]=infobox

[line_link]
Source=node/view/line.tpl
MatchFile=line/link.tpl
Subdir=templates
Match[class_identifier]=link

[line_multicalendar]
Source=node/view/line.tpl
MatchFile=line/multicalendar.tpl
Subdir=templates
Match[class_identifier]=multicalendar

[line_poll]
Source=node/view/line.tpl
MatchFile=line/poll.tpl
Subdir=templates
Match[class_identifier]=poll

[line_product]
Source=node/view/line.tpl
MatchFile=line/product.tpl
Subdir=templates
Match[class_identifier]=product

[line_silverlight]
Source=node/view/line.tpl
MatchFile=line/silverlight.tpl
Subdir=templates
Match[class_identifier]=silverlight

[line_quicktime]
Source=node/view/line.tpl
MatchFile=line/quicktime.tpl
Subdir=templates
Match[class_identifier]=quicktime

[line_real_video]
Source=node/view/line.tpl
MatchFile=line/real_video.tpl
Subdir=templates
Match[class_identifier]=real_video

[line_windows_media]
Source=node/view/line.tpl
MatchFile=line/windows_media.tpl
Subdir=templates
Match[class_identifier]=windows_media

[line_video]
Source=node/view/line.tpl
MatchFile=line/video.tpl
Subdir=templates
Match[class_identifier]=video

[edit_comment]
Source=content/edit.tpl
MatchFile=edit/comment.tpl
Subdir=templates
Match[class_identifier]=comment

[edit_file]
Source=content/edit.tpl
MatchFile=edit/file.tpl
Subdir=templates
Match[class_identifier]=file

[edit_forum_topic]
Source=content/edit.tpl
MatchFile=edit/forum_topic.tpl
Subdir=templates
Match[class_identifier]=forum_topic

[edit_ezsubtreesubscription_forum_topic]
Source=content/datatype/edit/ezsubtreesubscription.tpl
MatchFile=datatype/edit/forum_topic.tpl
Subdir=templates
Match[class_identifier]=forum_topic

[edit_forum_reply]
Source=content/edit.tpl
MatchFile=edit/forum_reply.tpl
Subdir=templates
Match[class_identifier]=forum_reply

[edit_landing_page]
Source=content/edit.tpl
MatchFile=edit/landing_page.tpl
Subdir=templates
Match[class_identifier]=landing_page

[highlighted_object]
Source=content/view/embed.tpl
MatchFile=embed/highlighted_object.tpl
Subdir=templates
Match[classification]=highlighted_object

[embed_article]
Source=content/view/embed.tpl
MatchFile=embed/article.tpl
Subdir=templates
Match[class_identifier]=article

[embed_banner]
Source=content/view/embed.tpl
MatchFile=embed/banner.tpl
Subdir=templates
Match[class_identifier]=banner

[embed_file]
Source=content/view/embed.tpl
MatchFile=embed/file.tpl
Subdir=templates
Match[class_identifier]=file

[embed_flash]
Source=content/view/embed.tpl
MatchFile=embed/flash.tpl
Subdir=templates
Match[class_identifier]=flash

[embed_flash_player]
Source=content/view/embed.tpl
MatchFile=embed/flash_player.tpl
Subdir=templates
Match[class_identifier]=flash_player

[itemized_sub_items]
Source=content/view/embed.tpl
MatchFile=embed/itemized_sub_items.tpl
Subdir=templates
Match[classification]=itemized_sub_items

[vertically_listed_sub_items]
Source=content/view/embed.tpl
MatchFile=embed/vertically_listed_sub_items.tpl
Subdir=templates
Match[classification]=vertically_listed_sub_items

[horizontally_listed_sub_items]
Source=content/view/embed.tpl
MatchFile=embed/horizontally_listed_sub_items.tpl
Subdir=templates
Match[classification]=horizontally_listed_sub_items

[itemized_subtree_items]
Source=content/view/embed.tpl
MatchFile=embed/itemized_subtree_items.tpl
Subdir=templates
Match[classification]=itemized_subtree_items

[embed_folder]
Source=content/view/embed.tpl
MatchFile=embed/folder.tpl
Subdir=templates
Match[class_identifier]=folder

[embed_forum]
Source=content/view/embed.tpl
MatchFile=embed/forum.tpl
Subdir=templates
Match[class_identifier]=forum

[embed_gallery]
Source=content/view/embed.tpl
MatchFile=embed/gallery.tpl
Subdir=templates
Match[class_identifier]=gallery

[embed_image]
Source=content/view/embed.tpl
MatchFile=embed/image.tpl
Subdir=templates
Match[class_identifier]=image

[embed_poll]
Source=content/view/embed.tpl
MatchFile=embed/poll.tpl
Subdir=templates
Match[class_identifier]=poll

[embed_product]
Source=content/view/embed.tpl
MatchFile=embed/product.tpl
Subdir=templates
Match[class_identifier]=product

[embed_quicktime]
Source=content/view/embed.tpl
MatchFile=embed/quicktime.tpl
Subdir=templates
Match[class_identifier]=quicktime

[embed_real_video]
Source=content/view/embed.tpl
MatchFile=embed/real_video.tpl
Subdir=templates
Match[class_identifier]=real_video

[embed_windows_media]
Source=content/view/embed.tpl
MatchFile=embed/windows_media.tpl
Subdir=templates
Match[class_identifier]=windows_media

[embed_video]
Source=content/view/embed.tpl
MatchFile=embed/video.tpl
Subdir=templates
Match[class_identifier]=video

[embed_inline_image]
Source=content/view/embed-inline.tpl
MatchFile=embed-inline/image.tpl
Subdir=templates
Match[class_identifier]=image

[embed_itemizedsubitems_gallery]
Source=content/view/itemizedsubitems.tpl
MatchFile=itemizedsubitems/gallery.tpl
Subdir=templates
Match[class_identifier]=gallery

[embed_itemizedsubitems_forum]
Source=content/view/itemizedsubitems.tpl
MatchFile=itemizedsubitems/forum.tpl
Subdir=templates
Match[class_identifier]=forum

[embed_itemizedsubitems_folder]
Source=content/view/itemizedsubitems.tpl
MatchFile=itemizedsubitems/folder.tpl
Subdir=templates
Match[class_identifier]=folder

[embed_itemizedsubitems_event_calendar]
Source=content/view/itemizedsubitems.tpl
MatchFile=itemizedsubitems/event_calendar.tpl
Subdir=templates
Match[class_identifier]=event_calendar

[embed_itemizedsubitems_wiki_page]
Source=content/view/itemizedsubitems.tpl
MatchFile=itemizedsubitems/wiki_page.tpl
Subdir=templates
Match[class_identifier]=wiki_page

[embed_itemizedsubitems_itemized_sub_items]
Source=content/view/itemizedsubitems.tpl
MatchFile=itemizedsubitems/itemized_sub_items.tpl
Subdir=templates

[embed_event_calendar]
Source=content/view/embed.tpl
MatchFile=embed/event_calendar.tpl
Subdir=templates
Match[class_identifier]=event_calendar

[embed_horizontallylistedsubitems_article]
Source=node/view/horizontallylistedsubitems.tpl
MatchFile=horizontallylistedsubitems/article.tpl
Subdir=templates
Match[class_identifier]=article

[embed_horizontallylistedsubitems_event]
Source=node/view/horizontallylistedsubitems.tpl
MatchFile=horizontallylistedsubitems/event.tpl
Subdir=templates
Match[class_identifier]=event

[embed_horizontallylistedsubitems_image]
Source=node/view/horizontallylistedsubitems.tpl
MatchFile=horizontallylistedsubitems/image.tpl
Subdir=templates
Match[class_identifier]=image

[embed_horizontallylistedsubitems_product]
Source=node/view/horizontallylistedsubitems.tpl
MatchFile=horizontallylistedsubitems/product.tpl
Subdir=templates
Match[class_identifier]=product

[ezgmaplocation_article]
Source=content/datatype/view/ezgmaplocation.tpl
MatchFile=datatype/view/ezgmaplocation_article.tpl
Subdir=templates
Match[class_identifier]=article

[ezstring_feedback_form]
Source=content/datatype/collect/ezstring.tpl
MatchFile=datatype/collect/ezstring_feedback_form.tpl
Subdir=templates
Match[class_identifier]=feedback_form

[ezemail_feedback_form]
Source=content/datatype/collect/ezemail.tpl
MatchFile=datatype/collect/ezemail_feedback_form.tpl
Subdir=templates
Match[class_identifier]=feedback_form

[eztext_feedback_form]
Source=content/datatype/collect/eztext.tpl
MatchFile=datatype/collect/eztext_feedback_form.tpl
Subdir=templates
Match[class_identifier]=feedback_form

[factbox]
Source=content/datatype/view/ezxmltags/factbox.tpl
MatchFile=datatype/ezxmltext/factbox.tpl
Subdir=templates

[quote]
Source=content/datatype/view/ezxmltags/quote.tpl
MatchFile=datatype/ezxmltext/quote.tpl
Subdir=templates

[table_cols]
Source=content/datatype/view/ezxmltags/table.tpl
MatchFile=datatype/ezxmltext/table_cols.tpl
Subdir=templates
Match[classification]=cols

[table_comparison]
Source=content/datatype/view/ezxmltags/table.tpl
MatchFile=datatype/ezxmltext/table_comparison.tpl
Subdir=templates
Match[classification]=comparison

[image_galleryline]
Source=node/view/galleryline.tpl
MatchFile=galleryline/image.tpl
Subdir=templates
Match[class_identifier]=image

[flash_player_galleryline]
Source=node/view/galleryline.tpl
MatchFile=galleryline/flash_player.tpl
Subdir=templates
Match[class_identifier]=flash_player

[image_galleryslide]
Source=node/view/galleryslide.tpl
MatchFile=galleryslide/image.tpl
Subdir=templates
Match[class_identifier]=image

[article_listitem]
Source=node/view/listitem.tpl
MatchFile=listitem/article.tpl
Subdir=templates
Match[class_identifier]=article

[image_listitem]
Source=node/view/listitem.tpl
MatchFile=listitem/image.tpl
Subdir=templates
Match[class_identifier]=image

[billboard_banner]
Source=content/view/billboard.tpl
MatchFile=billboard/banner.tpl
Subdir=templates
Match[class_identifier]=banner

[billboard_flash]
Source=content/view/billboard.tpl
MatchFile=billboard/flash.tpl
Subdir=templates
Match[class_identifier]=flash

[tiny_image]
Source=content/view/tiny.tpl
MatchFile=tiny_image.tpl
Subdir=templates
Match[class_identifier]=image
*/ ?>