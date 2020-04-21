<?php
namespace App\Application\Traits;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Uuid;

/**
 * UploadFile trait.
 */
trait UploadFileTrait
{
    /**
     * @param FilesystemInterface $filesystem
     * @param $data
     *
     * @throws \Exception
     *
     * @return mixed
     */
    private function uploadImage(FilesystemInterface $filesystem, User $data)
    {
        try {
            // Upload file
            $originalFile      = $data->getAvatarFile()->getClientOriginalName();
            $originalName      = substr($originalFile, 0, strrpos($originalFile, '.'));
            $originalExtension = $data->getAvatarFile()->getClientOriginalExtension();
            $filename          = substr($originalName, 0, 20) . '-' . Uuid::uuid4() . '.' . $originalExtension;

            $filesystem->write($filename, fopen($data->getAvatarFile()->getRealPath(), 'r'));

            // Remove previous file
            if ($data->getAvatar() && $filesystem->has($data->getAvatar())) {
                $filesystem->delete($data->getAvatar());

                $data->setAvatarFile(null);
            }

            $data->setAvatar($filename);
        } catch (\Exception $e) {
            throw new \Exception('An error occured while uploading file. Please try again.', Response::HTTP_NOT_FOUND, $e);
        }

        return $data;
    }
}
?>