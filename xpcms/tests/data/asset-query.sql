(SELECT a1.id AS asset_id, a1.position AS pos, wpa1.group_fid AS asset_group, at1.title AS title, at1.content AS objdata, NULL AS objdata2, 'text' AS objtype FROM 
  xpcms_web_page_to_asset AS wpa1,
  xpcms_asset AS a1,
  xpcms_asset_text at1
WHERE 
  wpa1.web_page_fid = 12 AND a1.id = wpa1.asset_fid AND 
  a1.status = 1 AND a1.language = 'de_DE' AND
  at1.asset_fid = a1.id)
UNION (
SELECT a2.id AS asset_id, a2.position AS pos, wpa2.group_fid AS asset_group, ai2.title AS title, ai2.url AS objdata, NULL AS objdata2, 'image' AS objtype FROM 
  xpcms_web_page_to_asset AS wpa2,
  xpcms_asset AS a2,
  xpcms_asset_image ai2
WHERE 
  wpa2.web_page_fid = 12 AND a2.id = wpa2.asset_fid AND 
  a2.status = 1 AND a2.language = 'de_DE' AND
  ai2.asset_fid = a2.id 
)
UNION (
SELECT a3.id AS asset_id, a3.position AS pos, wpa3.group_fid AS asset_group, al3.title AS title, al3.url AS objdata, al3.description AS objdata2, 'link' AS objtype FROM 
  xpcms_web_page_to_asset AS wpa3,
  xpcms_asset AS a3,
  xpcms_asset_link al3
WHERE 
  wpa3.web_page_fid = 12 AND a3.id = wpa3.asset_fid AND 
  a3.status = 1 AND a3.language = 'de_DE' AND
  al3.asset_fid = a3.id 
)
ORDER BY asset_group, pos