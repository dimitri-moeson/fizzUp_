<?php

declare(strict_types=1);

namespace App\Handler;

use App\Form\CommentForm;
use App\Model\Table\CommentsTable;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Csrf\CsrfMiddleware;
use Mezzio\Flash\FlashMessageMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;

class CommentHandler implements RequestHandlerInterface, MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $renderer;
    
    /**
     * @var \App\Form\CommentForm
     */
    private $commentForm;
    
    /**
     * @var \App\Model\Table\CommentsTable
     */
    private $commentsTable;
    
    
    public function __construct(CommentForm $commentForm, TemplateRendererInterface $renderer, CommentsTable $commentsTable )
    {
        $this->commentForm = $commentForm ;
        $this->renderer = $renderer;
        $this->commentsTable = $commentsTable;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        // Do some work...
        // Render and return a response:
        return new HtmlResponse($this->renderer->render(
            'app::comment',
            [
                'form' => $this->commentForm,
            ] // parameters to pass to template
        ));
    }
    
    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Do some work...
        
        # csrf
        $csrfToken = $request->getAttribute(CsrfMiddleware::GUARD_ATTRIBUTE);
        $this->commentForm->get('comment_csrf')->setValue(
            $csrfToken->generateToken()
        );
        
        # check post form ...
        if($request->getMethod() == "POST"){
            
            $this->commentForm->setInputFilter( $this->commentsTable->getComentFormFilter() );
            $this->commentForm->setData( $request->getParsedBody());
            
            if($this->commentForm->isValid()){
    
                $data = $request->getParsedBody();
                $data["photo"] = "";
                
                if(isset($_FILES['photo']))
                {
                    if (file_exists($_FILES['photo']['tmp_name']))
                    {
                            $data["photo"] = $this->save_photo() ;
                    }
                }
                $this->commentsTable->insertAvis( $data );
                
                $response = $handler->handle($request);
                
                $flashMessages = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
                
                if($response->getStatusCode() !== 302 ){
                    
                    $flashMessages->flash("success", "Votre commentaire a bien été enrtegistré");
                    return new RedirectResponse('/');
                }
                
                return $response ;
            }
        }
        
        // Render and return a response:
        return new HtmlResponse($this->renderer->render(
            'app::comment',
            [
                'form' => $this->commentForm,
            ] // parameters to pass to template
        ));
    }
    
    private function save_photo($max = 100){
    
        $typeok = TRUE;
    
        $name = basename($_FILES['photo']['name']);
    
        $saveto = 'public/images/' . $name;
        
        move_uploaded_file($_FILES['photo']['tmp_name'], $saveto);
    
        switch($_FILES['photo']['type'])
        {
            case "image/gif": $src = imagecreatefromgif($saveto); break;
            case "image/jpeg": // Both regular and progressive jpegs
            case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
            case "image/png": $src = imagecreatefrompng($saveto); break;
            default: $typeok = FALSE; break;
        }
        
        if ($typeok)
        {
            list($w, $h) = getimagesize($saveto);
            
            $tw = $w;
            $th = $h;
            if ($w > $h && $max < $w)
            {
                $th = intval($max / $w * $h);
                $tw = $max;
            }
            elseif ($h > $w && $max < $h)
            {
                $tw = intval($max / $h * $w);
                $th = $max;
            }
            elseif ($max < $w)
            {
                $tw = $th = $max;
            }
        
            $tmp = imagecreatetruecolor($tw, $th);
            imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
            imageconvolution($tmp, array( // Sharpen image
                [-1, -1, -1],
                [-1, 16, -1],
                [-1, -1, -1]
            ), 8, 0);
            imagejpeg($tmp, $saveto);
            imagedestroy($tmp);
            imagedestroy($src);
        }
        
        
        return $name ;
    }
}
