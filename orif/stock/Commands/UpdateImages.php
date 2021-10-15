<?php
namespace Stock\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use DirectoryIterator;
use Stock\Models\Item_model;

class UpdateImages extends BaseCommand
{
    protected $group        = 'stock';
    protected $name         = 'stock:update_images';
    protected $description  = 'Renames item images to match the current conventions, and deletes the unused ones';

    public function run(array $params)
    {
        $itemModel = new Item_model;
        $items = $itemModel->asArray()->findAll();
        $imagesPath = ROOTPATH.$config('\Stock\Config\StockConfig')->images_upload_path;

        foreach ($items as $item) {
            // Ignore item with no images, and those with correctly named images
            if (is_null($item['image']) || preg_match('/^\d{4}_picture\.png$/', $item['image'])) continue;

            $old_image = $item['image'];
            $new_image = str_pad($item['item_id'], 4, '0', STR_PAD_LEFT) . '_picture.png';

            $same_image_items = $itemModel->asArray()->where('image', $old_image)->find();

            if (count($same_image_items) >= 2) {
                // Copy the image to not break the other item
                copy($imagesPath.$old_image, $imagesPath.$new_image);
            } else {
                // Change the image's name to a correct one
                rename($imagesPath.$old_image, $imagesPath.$new_image);
            }

            $item['image'] = $new_image;
            $itemModel->update($item['item_id'], $item);
        }

        foreach (new DirectoryIterator($imagesPath) as $file_info) {
            // Not checking for correctly named images, as it doesn't need to be in use to be named so
            if ($file_info->isDot() || $file_info->isDir()) continue;

            // It's gonna give an array anyway, so we ask for one in case there is something
            $item = $itemModel->asArray()->where('image', $file_info->getFilename())->find();
            if (count($item)) continue;

            unlink($file_info->getPathname());
        }
    }
}
